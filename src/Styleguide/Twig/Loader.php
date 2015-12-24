<?php

namespace Labcoat\Styleguide\Twig;

class Loader extends \Twig_Loader_Array {

  protected $viewsPath;

  public static function findStyleguideTemplatesDirectory() {
    if (!$vendor = static::findVendorDirectory()) return null;
    $path = implode(DIRECTORY_SEPARATOR, [$vendor, 'pattern-lab', 'styleguidekit-twig-default', 'views']);
    return is_dir($path) ? $path : null;
  }

  public static function findVendorDirectory() {
    $className = "Composer\\Autoload\\ClassLoader";
    if (!class_exists($className)) return null;
    $c = new \ReflectionClass($className);
    return dirname(dirname($c->getFileName()));
  }

  public function __construct($path = null) {
    if (!isset($path)) $path = static::findStyleguideTemplatesDirectory();
    $this->viewsPath = $path;
    parent::__construct($this->getPatternLabTemplates());
  }

  protected function getPatternLabTemplates() {
    return [
      'partials/general-footer' => $this->getPatternLabTemplateContent('partials/general-footer.twig'),
      'partials/general-header' => $this->getPatternLabTemplateContent('partials/general-header.twig'),
      'patternSection.twig' => $this->getPatternLabTemplateContent('partials/patternSection.twig'),
      'patternSectionSubtype.twig' => $this->getPatternLabTemplateContent('partials/patternSectionSubtype.twig'),
      'viewall' => $this->getPatternLabTemplateContent('viewall.twig'),
    ];
  }

  protected function getPatternLabTemplateContent($path) {
    $file = $this->viewsPath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('/', $path));
    return file_get_contents($file);
  }
}