<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLabInterface;
use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubType;
use Labcoat\Patterns\PatternSubTypeInterface;
use Labcoat\Patterns\PatternType;
use Labcoat\Patterns\PatternTypeInterface;
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
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\Pages\PatternPage;

class Styleguide implements StyleguideInterface {

  protected $cacheBuster;

  protected $data;

  protected $indexFiles;

  /**
   * @var Navigation
   */
  protected $navigation;

  protected $patternFileSets;

  protected $patternlab;

  protected $pattern;

  protected $twig;

  public function __construct(PatternLabInterface $patternlab) {
    #$this->patternlab = $patternlab;
    $this->cacheBuster = time();
    $this->makeFiles($patternlab);
  }

  public function generate() {
    $this->writePatternPages();
  }

  public function getCacheBuster() {
    return $this->cacheBuster;
  }

  public function getNavigation() {
    return $this->navigation;
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

  protected function makeFiles(PatternLabInterface $patternlab) {
    $this->data = new DataFile();
    $this->navigation = new Navigation();

    $iterator = new \RecursiveIteratorIterator($patternlab->getPatterns(), \RecursiveIteratorIterator::SELF_FIRST);
    foreach ($iterator as $item) {
      if ($item instanceof PatternInterface) {
        $this->data->addPatternPath($item);
        $this->navigation->addPattern($item);
        foreach ($item->getPseudoPatterns() as $pseudo) {
          $this->data->addPatternPath($pseudo);
        }
      }
      elseif ($item instanceof PatternSubTypeInterface) {
        $this->data->addSubtypeIndexPath($item);
        $this->navigation->addSubtype($item);
      }
      elseif ($item instanceof PatternTypeInterface) {
        $this->navigation->addType($item);
      }
    }
  }

  protected function ensureDirectory($path) {
    if (!is_dir($path)) mkdir($path, $this->patternlab->getDefaultDirectoryPermissions(), true);
  }

  protected function ensurePathDirectory($path) {
    $this->ensureDirectory(dirname($path));
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

  protected function writePatternPages() {
    $patterns = [];
    foreach ($this->navigation->getTypes() as $type) {
      $typePatterns = [];
      foreach ($type->getSubtypes() as $subtype) {
        $subtypePatterns = [];
        foreach ($subtype->getPatterns() as $pattern) {
          $this->writePatternPage($pattern);
          $subtypePatterns[] = $pattern;
          $typePatterns[] = $pattern;
          $patterns[] = $pattern;
        }
        $this->writeSubtypePage($subtype, $subtypePatterns);
      }
      foreach ($type->getPatterns() as $pattern) {
        $this->writePatternPage($pattern);
        $typePatterns[] = $pattern;
        $patterns[] = $pattern;
      }
      $this->writeTypePage($type, $typePatterns);
    }
    $this->writeIndexPage($patterns);
  }
}