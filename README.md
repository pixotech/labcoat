# Labcoat: Pattern Lab for Production

Labcoat is a library for using Pattern Lab content in live site environments. It provides the ability to:

* [Render pattern templates](#rendering-pattern-templates)
* [Generate style guides using the Pattern Lab UI](#generating-style-guides)
* [Validate template content](#testing-content)

## Basic usage

Include the Labcoat library using [Composer](https://getcomposer.org/):

```json
{
  "require": {
    "pixo/labcoat": "dev-master"
  }
}
```

The PatternLab class represents a Pattern Lab installation. For [Standard Edition installations][standard edition], Labcoat needs the path to the installation root (containing `config` and `source` directories):

```php
$labcoat = \Labcoat\PatternLab::loadStandardEdition('/path/to/patternlab');
```

For an installation that uses Labcoat's default structure:

```php
$labcoat = \Labcoat\PatternLab::load('/path/to/patternlab');
```

For custom configurations, create a new Configuration object and use it as a constructor argument:

```php
$config = new \Labcoat\Configuration\Configuration();
$config->setPatternsPath('/path/to/pattern/templates');
$labcoat = new \Labcoat\PatternLab($config);
```

## Rendering pattern templates

Labcoat contains a [Twig loader][Twig loaders] class for using pattern templates in other applications.

```php
$loader = new Labcoat\Twig\Loader($labcoat);
$twig = new Twig_Environment($loader, ['cache' => '/path/to/twig/cache']);
```

The loader supports two methods of [including patterns][including patterns]:

* **Partial syntax**, i.e. `type-name`. Fuzzy matching is _not_ supported.
* **Path**, relative to the patterns directory. The file extension and any [ordering digits][ordering digits] are ignored.

```php
# These will all render the template "00-atoms/01-icons/email.twig"
print $twig->render('atoms-email');
print $twig->render('atoms/icons/email');
print $twig->render('00-atoms/01-icons/email');
print $twig->render('00-atoms/01-icons/email.twig');
print $twig->render('123-atoms/456-icons/email.twig');

# Fuzzy matching isn't supported, so this won't work
print $twig->render('atoms-em');
```

### Caching the loader

Once created, the loader class can be stored in a cache to save time during the next request. If Memcache is available:

```php
$makeLoaderIfNotInCache = function ($cache, $key, &$loader) {
  $labcoat = Labcoat\PatternLab::load('/path/to/patternlab');
  $loader = new Labcoat\Twig\Loader($labcoat);
};
$loader = $memcache->get('labcoat_loader', $makeLoaderIfNotInCache);
$twig = new Twig_Environment($loader);
```

If [Stash][Stash] is being used:

```php
$item = $stash->getItem('labcoat/loader');
$loader = $item->get();
if ($item->isMiss()) {
  $item->lock();
  $labcoat = Labcoat\PatternLab::load('/path/to/patternlab');
  $loader = new Labcoat\Twig\Loader($labcoat);
  $item->set($loader);
}
$twig = new Twig_Environment($loader);
```

### Combining with other loaders

The Labcoat loader can be chained with other loaders:

```php
$loader = new Twig_Loader_Chain([
  new Labcoat\Twig\Loader($labcoat),
  new Twig_Loader_Filesystem('/path/to/more/templates'),
]);
$twig = new Twig_Environment($loader);
```

### Creating HTML documents

The Document class makes full HTML pages from patterns:

```php
$doc = new Labcoat\Html\Document($twig->render('pages-about'));
$doc->setTitle('About Us');
$doc->includeStylesheet('/css/styles.min.css');
$doc->includeScript('/js/script.min.js');
print $doc;
```

## Generating style guides

```php
$labcoat = new Labcoat\PatternLab('/path/to/patternlab');
$styleguide = new Labcoat\Styleguide\Styleguide($labcoat);
$styleguide->generate('/path/to/styleguide');
```

## Testing content

Labcoat can use [pattern data files](http://patternlab.io/docs/data-pattern-specific.html) to validate classes that will represent live content in production environments.

For example, a template named `molecules-event` could have the following data file:

```json
{
  "event": {
    "name": "Company picnic",
    "date": "August 25",
    "time": "1:00pm",
    "private": true
  }
}
```

In production, the `event` variable will be an instance of the `Event` class.

```php
class Event {
  public $name;
  public function getDate() ...
  public function isPrivate() ...
}
```

Labcoat provides test methods to ensure that the `Event` class all the properties of `event` which are present in the data file.

```php
class EventTest extends \Labcoat\Data\TestCase {
  public function testEvent() {
    $labcoat = new \Labcoat\PatternLab("/path/to/patternlab");
    $pattern = $labcoat->getPattern("molecules-event");
    $this->assertPatternData($pattern, ["event" => "Event"]);
  }
}
```

When this test is run, the output will be something like this:

```
There was 1 failure:

1) EventTest::testEvent
Failed asserting that the data classes contain the required pattern variables.

Pattern: molecules/event
Template: /path/to/patternlab/source/_patterns/molecules/event.twig

event.name
  FOUND: Event::$name
event.date
  FOUND: Event::getDate(), line 15
event.time
  NOT FOUND
event.private
  FOUND: Event::isPrivate(), line 22
```

Labcoat can test nested variables, too.

```json
{
  "event": {
    "name": "Company picnic",
    "date": "August 25",
    "time": "1:00pm",
    "location": {
      "name": "Maplewood Park",
      "address": "10 Maplewood Way"
    }
  }
}
```

```php
class Location {
  public function getName() ...
  public function getAddress() ...
}
```

```php
$this->assertPatternData($pattern, [
  "event" => "Event",
  "event.location" => "Location",
]);
```

[standard edition]: https://github.com/pattern-lab/edition-php-twig-standard
[Twig loaders]: http://twig.sensiolabs.org/doc/api.html#loaders
[including patterns]: http://patternlab.io/docs/pattern-including.html
[ordering digits]: http://patternlab.io/docs/pattern-reorganizing.html
[Stash]: http://www.stashphp.com/
