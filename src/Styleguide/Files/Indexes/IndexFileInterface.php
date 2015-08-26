<?php

namespace Labcoat\Styleguide\Files\Indexes;

use Labcoat\Styleguide\Files\DynamicFileInterface;

interface IndexFileInterface extends DynamicFileInterface {
  public function getPatterns();
}