<?php

namespace Labcoat\Twig;

use Labcoat\PatternLab;

class Environment extends \Twig_Environment {

  protected $patternlab;

  public function __construct(PatternLab $patternlab, array $options = []) {
    $loader = new Loader($patternlab);
    parent::__construct($loader, $options);
  }
}