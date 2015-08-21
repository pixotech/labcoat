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
  }
}