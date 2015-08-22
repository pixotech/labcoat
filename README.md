# Labcoat

Labcoat is a PHP library for interacting with [Pattern Lab][patternlab] installations

```php
$labcoat = new \Labcoat\PatternLab("/path/to/patternlab");
```

```php
$twigOptions = [
  "cache" => "/path/to/twig/cache"
];
$labcoat = new \Labcoat\PatternLab("/path/to/patternlab", $twigOptions);
```

## Rendering templates

Labcoat supports these methods of including patterns:

* Shorthand
* Path
* Exact template name

Labcoat does not support these Twig features:

* Macros
* Custom filters
* Custom functions
* Custom tags
* Custom tests

```php
print $labcoat->render("templates-calendar", ['events' => $events]);
```

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

```php
$homepage = $labcoat->makeDocument("pages-home");
$homepage->setTitle("Welcome");
$homepage->includeStylesheet("/css/styles.css");
$homepage->includeScript("/js/scripts.css");
print $homepage;
```

## Copying assets

```php
$labcoat->copyAssetsTo("/path/to/production/site");
```

```bash
php labcoat.php copy --patternlab=/patternlab --directory=/production
```

## Validating data classes

```json
{
  "event": {
    "name": "Company picnic",
    "date": "August 25",
    "time": "1:00pm"
  }
}
```

```php
class Event {
  public function getName() ...
  public function getDate() ...
  public function getTime() ...
}
```

```php
class EventTest extends \Labcoat\Data\TestCase {
  public function testEvent() {
    $this->assertPattern("molecules-event", ["event" => "Event"]);
  }
}
```

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
public function testEvent() {
  $this->assertPattern("molecules-event", ["event.location" => "Location"]);
}
```

[patternlab]: http://patternlab.io/ "Pattern Lab website"