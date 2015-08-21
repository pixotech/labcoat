<?php

namespace Labcoat\Twig;

use Labcoat\PatternLabInterface;

class Environment extends \Twig_Environment {

  /**
   * @var PatternLabInterface
   */
  protected $patternlab;

  public function __construct(PatternLabInterface $patternlab, array $options = []) {
    $loader = new Loader($patternlab);
    parent::__construct($loader, $options);
    $this->configureDateFormats();
    $this->loadFilters();
    $this->loadFunctions();
    $this->loadMacros();
    $this->loadTags();
    $this->loadTests();
  }

  protected function configureDateFormats() {
    $dateFormat = $this->patternlab->getTwigDefaultDateFormat();
    $intervalFormat = $this->patternlab->getTwigDefaultIntervalFormat();
    if ($dateFormat && $intervalFormat) {
      $this->getExtension('core')->setDateFormat($dateFormat, $intervalFormat);
    }
  }

  protected function getFilterVariable($path) {
    $filter = null;
    include $path;
    return $filter;
  }

  protected function getFunctionVariable($path) {
    $function = null;
    include $path;
    return $function;
  }

  protected function getTestVariable($path) {
    $test = null;
    include $path;
    return $test;
  }

  protected function loadFilters() {
    $ext = $this->patternlab->getFilterExtension();
    foreach ($this->patternlab->getFilterFiles() as $file) {
      $name = $file->getBasename(".{$ext}");
      if ($name[0] == '_') continue;
      if ($filter = $this->getFilterVariable($file->getPathname())) $this->addFilter($filter);
    }
  }

  protected function loadFunctions() {
    $ext = $this->patternlab->getFunctionExtension();
    foreach ($this->patternlab->getFunctionFiles() as $file) {
      $name = $file->getBasename(".{$ext}");
      if ($name[0] == '_') continue;
      if ($func = $this->getFunctionVariable($file->getPathname())) $this->addFunction($func);
    }
  }

  protected function loadMacros() {
    $ext = $this->patternlab->getMacroExtension();
    foreach ($this->patternlab->getMacroFiles() as $file) {
      $name = $file->getBasename(".{$ext}");
      if ($name[0] == '_') continue;
      $this->addGlobal($name, file_get_contents($file->getPathname()));
    }
  }

  protected function loadTags() {
    $ext = $this->patternlab->getTagExtension();
    foreach ($this->patternlab->getTagFiles() as $file) {
      $name = $file->getBasename(".{$ext}");
      if ($name[0] == '_') continue;
      include_once $file->getPathname();
      $className = "Project_{$name}_TokenParser";
      if (class_exists($className)) {
        $tagClass = new \ReflectionClass($className);
        $this->addTokenParser($tagClass->newInstance());
      }
    }
  }

  protected function loadTests() {
    $ext = $this->patternlab->getTestExtension();
    foreach ($this->patternlab->getTestFiles() as $file) {
      $name = $file->getBasename(".{$ext}");
      if ($name[0] == '_') continue;
      if ($test = $this->getTestVariable($file->getPathname())) $this->addTest($test);
    }
  }
}