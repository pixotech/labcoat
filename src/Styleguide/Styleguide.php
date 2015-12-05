<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\Styleguide;

use Labcoat\PatternLab;
use Labcoat\PatternLabInterface;
use Labcoat\Styleguide\Files\AnnotationsFile;
use Labcoat\Styleguide\Files\AssetFile;
use Labcoat\Styleguide\Files\DataFile;
use Labcoat\Styleguide\Files\FileInterface;
use Labcoat\Styleguide\Files\LatestChangeFile;
use Labcoat\Styleguide\Files\PageFile;
use Labcoat\Styleguide\Files\PatternEscapedSourceFile;
use Labcoat\Styleguide\Files\PatternSourceFile;
use Labcoat\Styleguide\Files\PatternTemplateFile;
use Labcoat\Styleguide\Generator\Generator;
use Labcoat\Styleguide\Pages\PatternPage;
use Labcoat\Styleguide\Pages\PatternPageInterface;
use Labcoat\Styleguide\Pages\StyleguideIndexPage;
use Labcoat\Styleguide\Pages\SubTypeIndexPage;
use Labcoat\Styleguide\Pages\TypeIndexPage;

class Styleguide implements \IteratorAggregate, StyleguideInterface {

  /**
   * @var int
   */
  protected $cacheBuster;

  /**
   * @var \Labcoat\Styleguide\Files\FileInterface[]
   */
  protected $files = [];

  /**
   * @var array|null
   */
  protected $globalData;

  /**
   * @var \Labcoat\PatternLabInterface
   */
  protected $patternlab;

  /**
   * @var \Twig_Environment
   */
  protected $templateParser;

  /**
   * @param PatternLabInterface $patternlab
   */
  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
    $this->makeCacheBuster();
    $this->makeFiles();
  }

  public function __toString() {
    $str = '';
    foreach ($this->files as $file) {
      $str .= $file->getPath() . "\n";
      $str .= '  ' . date('r', $file->getTime()) . "\n";
    }
    return $str;
  }

  /**
   * {@inheritdoc}
   */
  public function generate($directory) {
    $generator = new Generator($this, $directory);
    return $generator->__invoke();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheBuster() {
    return $this->cacheBuster;
  }

  /**
   * {@inheritdoc}
   */
  public function getGlobalData() {
    if (!isset($this->globalData)) $this->globalData = $this->patternlab->getGlobalData();
    return $this->globalData;
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator() {
    return new \ArrayIterator($this->files);
  }

  /**
   * {@inheritdoc}
   */
  public function getMaximumWidth() {
    return '2600';
  }

  /**
   * {@inheritdoc}
   */
  public function getMinimumWidth() {
    return '240';
  }

  /**
   * {@inheritdoc}
   */
  public function getPatternLab() {
    return $this->patternlab;
  }

  /**
   * {@inheritdoc}
   */
  public function render($template, array $data = []) {
    return $this->getTemplateParser()->render($template, $data);
  }

  /**
   * Add a file to the style guide
   *
   * @param FileInterface $file A file object
   */
  protected function addFile(FileInterface $file) {
    $this->files[$file->getPath()] = $file;
  }

  protected function findAssetsDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = PatternLab::makePath([$vendor, 'pattern-lab', 'styleguidekit-assets-default', 'dist']);
    return is_dir($path) ? $path : null;
  }

  protected function findTemplatesDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = PatternLab::makePath([$vendor, 'pattern-lab', 'styleguidekit-twig-default', 'views']);
    return is_dir($path) ? $path : null;
  }

  protected function findVendorDirectory() {
    $className = "Composer\\Autoload\\ClassLoader";
    if (!class_exists($className)) return null;
    $c = new \ReflectionClass($className);
    return dirname($c->getFileName()) . '/..';
  }

  /**
   * Get the path to the style guide footer template
   *
   * @return string The template path
   */
  protected function getPatternFooterTemplatePath() {
    return $this->patternlab->getStyleguideFooter();
  }

  /**
   * Get the path to the style guide header template
   *
   * @return string The template path
   */
  protected function getPatternHeaderTemplatePath() {
    return $this->patternlab->getStyleguideHeader();
  }

  /**
   * Get the content of a template
   *
   * @param string $template The path to the tempalte
   * @return string The content of the template
   */
  protected function getStyleguideTemplateContent($template) {
    return file_get_contents($this->getStyleguideTemplatePath($template));
  }

  /**
   * Get the full path to a style guide template
   *
   * @param string $template The relative path of the template
   * @return string The full template path
   */
  protected function getStyleguideTemplatePath($template) {
    return PatternLab::makePath([$this->patternlab->getStyleguideTemplatesDirectory(), $template]);
  }

  /**
   * Get the Twig parser for style guide templates
   *
   * @return \Twig_Environment A Twig parser object
   */
  protected function getTemplateParser() {
    if (!isset($this->templateParser)) $this->makeTemplateParser();
    return $this->templateParser;
  }

  protected function hasFolderIndexes() {
    return true;
  }

  /**
   * Make the annotations file object
   */
  protected function makeAnnotationsFile() {
    if ($path = $this->patternlab->getAnnotationsFile()) {
      $this->addFile(new AnnotationsFile($path));
    }
  }

  /**
   */
  protected function makeCacheBuster() {
    $this->cacheBuster = time();
  }

  /**
   * Make the Pattern Lab data file object
   */
  protected function makeDataFile() {
    $this->addFile(new DataFile($this->patternlab));
  }

  /**
   * Make all file objects
   */
  protected function makeFiles() {
    $this->makePageFiles($this->makePages());
    $this->makeAssetFiles();
    $this->makeDataFile();
    $this->makeAnnotationsFile();
    $this->makeLatestChangeFile();
  }

  protected function makeIndexPages() {
    $pages = [new StyleguideIndexPage()];
    foreach ($this->patternlab->getTypes() as $type) {
      $pages[] = new TypeIndexPage($type);
      foreach ($type->getSubtypes() as $subtype) {
        $pages[] = new SubTypeIndexPage($subtype);
      }
    }
    return $pages;
  }

  /**
   * Make the latest change file object
   */
  protected function makeLatestChangeFile() {
    $this->addFile(new LatestChangeFile(time()));
  }

  /**
   * Make file objects for all the style guide pages
   *
   * @param \Labcoat\Styleguide\Pages\PageInterface[] An array of page objects
   * @return \Labcoat\Styleguide\Files\FileInterface[] $pages An array of page file objects
   */
  protected function makePageFiles(array $pages) {
    foreach ($pages as $page) {
      $this->addFile(new PageFile($page));
      if ($page instanceof PatternPageInterface) {
        $this->addFile(new PatternSourceFile($page->getPattern()));
        $this->addFile(new PatternEscapedSourceFile($page->getPattern()));
        $this->addFile(new PatternTemplateFile($page->getPattern()));
      }
    }
  }

  /**
   * Make the style guide page objects
   *
   * @return \Labcoat\Styleguide\Pages\PageInterface[] An array of page objects
   */
  protected function makePages() {
    $pages = $this->makePatternPages();
    if ($this->hasFolderIndexes()) $pages = array_merge($this->makeIndexPages(), $pages);
    return $pages;
  }

  protected function makePatternPages() {
    $pages = [];
    foreach ($this->patternlab->getPatterns() as $pattern) {
      $pages[] = new PatternPage($pattern);
    }
    return $pages;
  }

  /**
   * Make all style guide asset file objects
   */
  protected function makeAssetFiles() {
    if (!$assetsDir = $this->findAssetsDirectory()) return;
    $dir = new \RecursiveDirectoryIterator($assetsDir, \FilesystemIterator::SKIP_DOTS);
    $files = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($files as $file => $obj) {
      $path = substr($file, strlen($assetsDir) + 1);
      $this->addFile(new AssetFile($path, $file));
    }
  }

  /**
   * Make the Twig parser for style guide template files
   */
  protected function makeTemplateParser() {
    $templates = [
      'partials/general-footer' => $this->getStyleguideTemplateContent('partials/general-footer.twig'),
      'partials/general-header' => $this->getStyleguideTemplateContent('partials/general-header.twig'),
      'patternSection.twig' => $this->getStyleguideTemplateContent('partials/patternSection.twig'),
      'patternSectionSubtype.twig' => $this->getStyleguideTemplateContent('partials/patternSectionSubtype.twig'),
      'viewall' => $this->getStyleguideTemplateContent('viewall.twig'),
    ];
    $templates['patternLabHead'] = file_get_contents($this->getPatternHeaderTemplatePath());
    $templates['patternLabFoot'] = file_get_contents($this->getPatternFooterTemplatePath());
    $loader = new \Twig_Loader_Array($templates);
    $this->templateParser = new \Twig_Environment($loader, ['cache' => false]);
  }
}