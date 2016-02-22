<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

use Labcoat\Generator\Files\FileInterface;

interface PageInterface extends FileInterface {

  /**
   * @return string
   */
  public function getContent();

  /**
   * @return array
   */
  public function getData();
}