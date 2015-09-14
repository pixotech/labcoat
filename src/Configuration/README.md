# Configuration

Configuration objects determine where Labcoat will look for files. They also control some features of the style guide interface.

Labcoat comes with two configuration subclasses, for use with common Pattern Lab installations.

## Standard Edition configuration

This configuration class is for installations of the [Pattern Lab Standard Edition for Twig](https://github.com/pattern-lab/edition-php-twig-standard). It expects the following file structure:

* config
  * config.yml
* source
  * _annotations
  * _data
  * _meta
    * _00-head.twig
    * _01-foot.twig
  * _patterns
  * styleguide

```php
$config = new Labcoat\Configuration\StandardEditionConfiguration('/path/to/patternlab');
$labcoat = new Labcoat\PatternLab($config);

# If you don't need to modify the $config variable, you can use
$labcoat = Labcoat\PatternLab::loadStandardEdition('/path/to/patternlab');
```

## Labcoat configuration

This class expects the following file structure:

* assets
* data
* patterns
* styleguide
  * footer.twig
  * header.twig
  * assets

```php
$config = new Labcoat\Configuration\LabcoatConfiguration('/path/to/patternlab');
$labcoat = new Labcoat\PatternLab($config);

# If you don't need to modify the $config variable, you can use
$labcoat = Labcoat\PatternLab::load('/path/to/patternlab');
```

## Comparison of file locations

| File              | Standard Edition                   | Labcoat                   |
| ----------------- | ---------------------------------- | ------------------------- |
| Patterns          | source/_patterns                   | patterns                  |
| Global data       | source/_data                       | data                      |
| Assets            | source                             | assets                    |
| Annotations       | source/_annotations/annotations.js | styleguide/annotations.js |
| Header template   | source/_meta/_00-head.twig         | styleguide/header.twig    |
| Footer template   | source/_meta/_01-foot.twig         | styleguide/footer.twig    |
| Styleguide assets | source/styleguide                  | styleguide/assets         |

<dl>
<dt>Patterns</dt>
<dd>Pattern templates and pattern-specific data files</dd>
<dt>Global data</dt>
<dd>Data shared by all patterns and styleguide pages</dd>
<dt>Assets</dt>
<dd>Static files (stylesheets, scripts, images) used by both the styleguide and the production site</dd>
<dt>Annotations</dt>
<dd>A Javascript file containing pattern annotations</dd>
<dt>Header template</dt>
<dd>Twig template for styleguide page headers</dd>
<dt>Footer template</dt>
<dd>Twig template for styleguide page footers</dd>
<dt>Styleguide assets</dt>
<dd>Static files used only by the styleguide</dd>
</dl>

## Advanced configuration

Configuration objects provide the following customization methods:

<dl>
<dt>addAssetDirectory($path)</dt>
<dd>Add a path to the list of asset directories</dd>
<dt>addGlobalData($path)</dt>
<dd>Add a path to a global data file</dd>
<dt>addListItems($path)</dt>
<dd>Add the path to a list items data file</dd>
<dt>addStyleguideAssetDirectory($path)</dt>
<dd>Add a path to the list of styleguide asset directories</dd>
<dt>setAnnotationsFile($path)</dt>
<dd>Set the path to the annotations.js file</dd>
<dt>setExposedOptions($options)</dt>
<dd>Set the exposed options</dd>
<dt>setHiddenControls($controls)</dt>
<dd>Specify which controls should be hidden</dd>
<dt>setIgnoredDirectories($directories)</dt>
<dd>Specify which asset directories should be ignored</dd>
<dt>setIgnoredExtensions($extensions)</dt>
<dd>Specify which asset extensions should be ignored</dd>
<dt>setPatternExtension($extension)</dt>
<dd>Specify the extension of pattern template files (i.e. "twig")</dd>
<dt>setPatternsDirectory($path)</dt>
<dd>Specify the path of the directory that contains pattern templates</dd>
<dt>setStyleguideFooter($path)</dt>
<dd>Set the path to the styleguide footer template</dd>
<dt>setStyleguideHeader($path)</dt>
<dd>Set the path to the styleguide header template</dd>
<dt>setStyleguideTemplatesDirectory($path)</dt>
<dd>Specify the directory that contains the styleguide template files</dd>
<dt>setTwigOptions($options)</dt>
<dd>Specify options for the Twig parser</dd>
</dl>