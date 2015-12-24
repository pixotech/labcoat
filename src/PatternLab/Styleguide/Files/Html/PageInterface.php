<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

use Labcoat\Generator\Files\FileInterface;

interface PageInterface extends FileInterface {
  public function getContent();
  public function getData();

  /**
   * @return array
   */
  public function getVariables();
}