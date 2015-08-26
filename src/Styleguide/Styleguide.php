<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLabInterface;
use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubType;
use Labcoat\Patterns\PatternType;
use Labcoat\Styleguide\Files\AnnotationsFile;
use Labcoat\Styleguide\Files\DynamicFileInterface;
use Labcoat\Styleguide\Files\PatternEscapedHtmlFile;
use Labcoat\Styleguide\Files\PatternHtmlFile;
use Labcoat\Styleguide\Files\PatternPageFile;
use Labcoat\Styleguide\Files\PatternTemplateFile;
use Labcoat\Styleguide\Files\StyleguideIndexFile;
use Labcoat\Styleguide\Files\SubTypeIndexFile;
use Labcoat\Styleguide\Files\TypeIndexFile;
use Labcoat\Styleguide\Pages\PageCollection;
use Labcoat\Styleguide\Pages\PatternPage;

class Styleguide implements StyleguideInterface {

  protected $data;

  /**
   * @var PageCollection
   */
  protected $pages;

  protected $patternlab;
  protected $twig;

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
    return 0;
  }

  public function getGlobalData($reload = false) {
    if ($reload || !isset($this->data)) {
      $this->data = [];
      foreach ($this->findGlobalDataFiles() as $path) {
        $this->data += json_decode(file_get_contents($path), true);
      }
    }
    return $this->data;
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

  public function makeFooter(array $data = []) {
    $data += ['cacheBuster' => $this->getCacheBuster()];
    $data['patternLabFoot'] = $this->makePatternFooter($data);
    return $this->getTwig()->render('patternLabFoot', $data);
  }

  public function makeHeader(array $data = []) {
    $data += ['cacheBuster' => $this->getCacheBuster()];
    $data['patternLabHead'] = $this->makePatternHeader($data);
    return $this->getTwig()->render('patternLabHead', $data);
  }

  public function makePatternFooter(array $data = []) {
    $data += ['cacheBuster' => $this->getCacheBuster()];
    return $this->getTwig()->render('partials/general-footer', $data);
  }

  public function makePatternHeader(array $data = []) {
    $data += ['cacheBuster' => $this->getCacheBuster()];
    return $this->getTwig()->render('partials/general-header', $data);
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
    $patterns = $this->patternlab->getPatterns();
    $files[] = new StyleguideIndexFile($patterns);
    $iterator = new \RecursiveIteratorIterator($patterns, \RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($iterator as $item) {
      if ($item instanceof Pattern) {
        $files = array_merge($files, $this->makePatternFiles($item));
        foreach ($item->getPseudoPatterns() as $pseudoPattern) {
          $files = array_merge($files, $this->makePatternFiles($pseudoPattern));
        }
      }
      elseif ($item instanceof PatternType) {
        $files[] = new TypeIndexFile($item);
      }
      elseif ($item instanceof PatternSubType) {
        $files[] = new SubTypeIndexFile($item);
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

  protected function findGlobalDataFiles() {
    $files = [];
    $dir = new \FilesystemIterator($this->patternlab->getDataDirectory(), \FilesystemIterator::SKIP_DOTS);
    foreach ($dir as $file) {
      if ($file->getExtension() == 'json') $files[] = $file->getPathname();
    }
    sort($files);
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