# Labcoat: Pattern Lab for Production

Labcoat is a library for using Pattern Lab content in live site environments. It provides the ability to:

* [Render pattern templates](#rendering-pattern-templates)
* [Generate style guides using the Pattern Lab UI](#generating-style-guides)
* [Validate template content](#validating-template-content)

Labcoat places the following restrictions on Pattern Lab installations:

* Twig is the only supported templating language
* Patterns can only be referenced by partial and path syntax
* Layouts, macros, and other advanced Twig features are not supported

Labcoat was created by [Pixo](http://pixotech.com/), and released under the [NCSA license](https://opensource.org/licenses/NCSA).

Pattern Lab was created by [Brad Frost](http://bradfrostweb.com) and [Dave Olsen](http://dmolsen.com), and released under the [MIT license](https://opensource.org/licenses/MIT).

## Basic usage

Include the Labcoat library using [Composer](https://getcomposer.org/):

```json
{
  "require": {
    "pixo/labcoat": "^1.0.0"
  }
}
```

The PatternLab class represents a Pattern Lab installation. For [Standard Edition installations][standard edition], Labcoat needs the path to the installation root (containing `config` and `source` directories):

```php
$labcoat = Labcoat\PatternLab::loadStandardEdition('/path/to/patternlab');
```

For an installation that uses Labcoat's default structure:

```php
$labcoat = Labcoat\PatternLab::load('/path/to/patternlab');
```

For custom configurations, create a new Configuration object and use it as a constructor argument:

```php
$config = new Labcoat\Configuration\Configuration();
$config->setPatternsPath('/path/to/pattern/templates');
$labcoat = new Labcoat\PatternLab($config);
```

* [More about Labcoat configuration](src/Configuration)

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

Labcoat can generate style guides that use the [Pattern Lab interface](https://github.com/pattern-lab/styleguidekit-assets-default)

```php
$labcoat = new Labcoat\PatternLab('/path/to/patternlab');
$styleguide = new Labcoat\Styleguide\Styleguide($labcoat);
$styleguide->generate('/path/to/styleguide');
```

Use PHP's [built-in webserver](http://us1.php.net/manual/en/features.commandline.webserver.php) to browse the style guide locally (at http://localhost:8080, in this example):

```bash
php -S 0.0.0.0:8080 -t /path/to/styleguide
```

### Reporting

The `generate()` method returns a report object, which can be printed to obtain a summary of the generation process:

```php
print $styleguide->generate('/path/to/styleguide');
```

Which produces something like:

```txt
443 files updated, 0 skipped, 0 removed
Generated in 1.432264 seconds
```

To get a full report of style guide file changes, use the `verbose()` method of the report:

```php
print $styleguide->generate('/path/to/styleguide')->verbose();
```

```txt
...
index.html
  Updated (0.60 ms)
styleguide/data/patternlab-data.js
  Updated (1.41 ms)
annotations/annotations.js
  Updated (0.52 ms)
latest-change.txt
  Updated (0.18 ms)

443 files updated, 0 skipped, 0 removed
Generated in 1.432264 seconds
```

## Validating template content

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

In production, the `event` variable will be an instance of the `Event` class. This class has properties and methods that [Twig will treat like attributes of the variable](http://twig.sensiolabs.org/doc/templates.html#variables).

```php
class Event {
  public $name;
  public function getDate() ...
  public function isPrivate() ...
}
```

Labcoat provides test methods to ensure that the `Event` class has all the attributes of `event` which are present in the data file.

```php
class EventTest extends Labcoat\Testing\TestCase {
  public function testEvent() {
    $labcoat = new Labcoat\PatternLab("/path/to/patternlab");
    $this->assertPatternData($labcoat, "molecules-event#event", "Event");
  }
}
```

When this test is run, the output will be something like this:

```
There was 1 failure:

1) EventTest::testEvent
Failed asserting that the data classes contain the required pattern variables.

molecules-event#event.name
  FOUND: Event::$name
molecules-event#event.date
  FOUND: Event::getDate(), line 15
molecules-event#event.time
  NOT FOUND
molecules-event#event.private
  FOUND: Event::isPrivate(), line 22
```

[standard edition]: https://github.com/pattern-lab/edition-php-twig-standard
[Twig loaders]: http://twig.sensiolabs.org/doc/api.html#loaders
[including patterns]: http://patternlab.io/docs/pattern-including.html
[ordering digits]: http://patternlab.io/docs/pattern-reorganizing.html
[Stash]: http://www.stashphp.com/