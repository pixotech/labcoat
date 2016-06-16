Labcoat contains utilities for creating online style guides, like [Pattern Lab][Pattern Lab]. PHP 5.5+ is required.

## Creating a Pattern Lab style guide with Labcoat

```php
$styleguide = new Labcoat\PatternLab\Styleguide\Styleguide();
```

```php
$styleguide->addStylesheet('/css/styles.css');
$styleguide->addScript('/js/scripts.js');
$styleguide->setBreakpoints([360, 720, 1080]);
$styleguide->setHiddenControls(['disco', 'hay']);
```

```php
$pattern = new Labcoat\PatternLab\Patterns\Pattern('headline', 'atoms');
$pattern->setLabel('Headline');
$pattern->setTemplate('<h1>{{ headline }}</h1>');
$pattern->setExample('<h1>Big Announcement Expected Today</h1>');

$styleguide->addPattern($pattern);
```

```php
print call_user_func(new Labcoat\Generator\Generator($styleguide, '/path/to/patternlab'));
```

## Variables

```php
$variables = [
  'article' => '{{ $article }}'
];

$parser = new Labcoat\Variables\Parser();
$parser['article'] = [
  'headline' => 'Community Honors Retiring Teacher',
  'date' => 'June 5, 2015'
];

var_dump($parser->parse($variables);
```

```
array(1) {
  ["article"]=>
  array(2) {
    ["headline"]=>
    string(28) "Community Honors Retiring Teacher"
    ["date"]=>
    string(11) "June 5, 2015"
  }
}
```

```php
$variables = [
  'headline' => '{{ $article#headline }}'
];

var_dump($parser->parse($variables));
```

```
array(1) {
  ["headline"]=>
  string(28) "Community Honors Retiring Teacher"
}
```

### Fixtures

```php
$variables = [
  'article' => '{{ \\Project\\Fixtures\\Article }}'
];

var_dump($parser->parse($variables);
```

```
array(1) {
  ["article"]=>
  object(Project\Fixtures\Article)#1234 (0) {
  }
}
```

[Pattern Lab]: http://patternlab.io/