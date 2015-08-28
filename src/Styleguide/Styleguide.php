<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLabInterface;
use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubType;
use Labcoat\Patterns\PatternType;
use Labcoat\Styleguide\Files\AnnotationsFile;
use Labcoat\Styleguide\Files\DataFile;
use Labcoat\Styleguide\Files\DynamicFileInterface;
use Labcoat\Styleguide\Files\PatternEscapedHtmlFile;
use Labcoat\Styleguide\Files\PatternHtmlFile;
use Labcoat\Styleguide\Files\PatternPageFile;
use Labcoat\Styleguide\Files\PatternTemplateFile;
use Labcoat\Styleguide\Files\StyleguideIndexFile;
use Labcoat\Styleguide\Files\SubTypeIndexFile;
use Labcoat\Styleguide\Files\TypeIndexFile;
use Labcoat\Styleguide\Pages\PatternPage;

class Styleguide implements StyleguideInterface {

  protected $data;

  protected $patternlab;
  protected $twig;

  public static function makePatternPath(PatternInterface $pattern) {
    $pathName = $pattern->getStyleguidePathName();
    return $pathName . DIRECTORY_SEPARATOR . $pathName . '.html';
  }

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
  }

  public function generate($destination) {
    $files = $this->makeFiles();
    foreach ($files as $file) {
      $path = $this->makeDestinationPath($destination, $file->getPath());
      if ($file instanceof DynamicFileInterface) {
        $this->writeFile($path, $file->getContents());
      }
    }
  }

  public function getCacheBuster() {
    return time();
  }

  public function getPatternLab() {
    return $this->patternlab;
  }

  /**
   * @return \Twig_Environment
   */
  public function getTwig() {
    if (!isset($this->twig)) $this->makeTwig();
    return $this->twig;
  }

  public function renderPattern(PatternInterface $pattern) {
    $template = $pattern->getTemplate();
    $data = array_merge_recursive($this->getPatternLab()->getData(), $pattern->getData());
    return $this->getPatternLab()->render($template, $data);
  }

  protected function createPatterns() {
    $patterns = $this->patternlab->getPatterns();
    $iterator = new \RecursiveIteratorIterator($patterns, \RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($iterator as $item) {
      if ($item instanceof Pattern) {
        $page = new PatternPage($this, $item);
        print $page;
        break;
      }
    }
  }

  protected function ensureDirectory($path) {
    if (!is_dir($path)) mkdir($path, $this->patternlab->getDefaultDirectoryPermissions(), true);
  }

  protected function ensurePathDirectory($path) {
    $this->ensureDirectory(dirname($path));
  }

  protected function makeAllPatternFiles() {
    $files = [];
    $files[] = new DataFile($this->getPatternLab());
    $files[] = new StyleguideIndexFile($this);
    $iterator = new \RecursiveIteratorIterator($this->patternlab->getPatterns(), \RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($iterator as $item) {
      if ($item instanceof Pattern) {
        $files = array_merge($files, $this->makePatternFiles($item));
        foreach ($item->getPseudoPatterns() as $pseudoPattern) {
          $files = array_merge($files, $this->makePatternFiles($pseudoPattern));
        }
      }
      elseif ($item instanceof PatternType) {
        $files[] = new TypeIndexFile($this, $item);
      }
      elseif ($item instanceof PatternSubType) {
        $files[] = new SubTypeIndexFile($this, $item);
      }
    }
    return $files;
  }

  protected function makeAnnotationsFile() {
    return new AnnotationsFile();
  }

  protected function makeDestinationPath($dir, $path) {
    return $dir . DIRECTORY_SEPARATOR . $path;
  }

  /**
   * @return \Labcoat\Styleguide\Files\FileInterface[]
   */
  protected function makeFiles() {
    $files = [];
    $files = array_merge($files, $this->makeAllPatternFiles());
    return $files;
  }

  protected function makePatternFiles(PatternInterface $pattern) {
    $files = [];
    $files[] = new PatternTemplateFile($this, $pattern);
    $files[] = new PatternHtmlFile($this, $pattern);
    $files[] = new PatternEscapedHtmlFile($this, $pattern);
    $files[] = new PatternPageFile($this, $pattern);
    return $files;
  }

  protected function getPatternFooterTemplatePath() {
    return $this->patternlab->getMetaDirectory() . DIRECTORY_SEPARATOR . '_01-foot.twig';
  }

  protected function getPatternHeaderTemplatePath() {
    return $this->patternlab->getMetaDirectory() . DIRECTORY_SEPARATOR . '_00-head.twig';
  }

  protected function getStyleguideTemplateContent($template) {
    return file_get_contents($this->getStyleguideTemplatePath($template));
  }

  protected function getStyleguideTemplatePath($template) {
    return $this->getStyleguideTemplatesPath() . DIRECTORY_SEPARATOR . $template;
  }

  protected function getStyleguideTemplatesPath() {
    return $this->patternlab->getVendorDirectory() . '/pattern-lab/styleguidekit-twig-default/views';
  }

  protected function makeTwig() {
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
    $this->twig = new \Twig_Environment($loader, ['cache' => false]);
  }

  protected function writeFile($path, $content) {
    $this->ensurePathDirectory($path);
    file_put_contents($path, $content);
  }
}