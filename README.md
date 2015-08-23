# Labcoat

Labcoat is a PHP library for interacting with [Pattern Lab][patternlab] installations which use the [Twig PatternEngine](https://github.com/pattern-lab/patternengine-php-twig). It is designed to allow Pattern Lab contents to be used in production environments.

Labcoat's PatternLab class represents a single Pattern Lab installation.

```php
$labcoat = new \Labcoat\PatternLab("/path/to/patternlab");
```

It can also take an array of options to be used when creating the Twig parser.

```php
$twigOptions = [
  "cache" => "/path/to/twig/cache"
];
$labcoat = new \Labcoat\PatternLab("/path/to/patternlab", $twigOptions);
```

## Rendering templates

Labcoat supports these methods of [including patterns](http://patternlab.io/docs/pattern-including.html):

* **Shorthand**, e.g. `atoms-button` or `pages-contact`. Fuzzy matching is not supported. 
* **Path**, relative to the `source/_patterns` directory, without the template extension. Ordering prefixes are disregarded.

Labcoat does not support these Twig features:

* Macros
* Custom filters
* Custom functions
* Custom tags
* Custom tests

The `render()` method takes a pattern name (shorthand or path) and an array of template variables.

```php
print $labcoat->render("templates-calendar", ['events' => $events]);
```

If an object is passed instead of an array, Labcoat will use the public properties of the object as template variables.

```php
class Calendar {
  public $events;
  
  public function __construct() {
    $this->events = $this->getEvents();
  }
}

$calendar = new Calendar();
print $labcoat->render("templates-calendar", $calendar);
```

Labcoat's `makeDocument()` method creates complete HTML documents from patterns.

```php
$homepage = $labcoat->makeDocument("pages-home");
$homepage->setTitle("Welcome");
$homepage->includeStylesheet("/css/styles.css");
$homepage->includeScript("/js/scripts.css");
print $homepage;
```

## Copying assets

Labcoat provides a command-line utility for copying asset files from Pattern Lab to another directory. The `copy-assets.php` script is found in the root of the Labcoat library.

```bash
php copy-assets.php /path/to/patternlab /path/to/production
```

## Validating data classes

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

[patternlab]: http://patternlab.io/ "Pattern Lab website"