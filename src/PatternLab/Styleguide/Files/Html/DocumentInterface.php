<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

interface DocumentInterface extends \Labcoat\Html\DocumentInterface {

  public function getData();

  public function getStyleguide();
}