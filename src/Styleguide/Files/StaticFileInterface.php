<?php

namespace Labcoat\Styleguide\Files;

interface StaticFileInterface extends FileInterface {
  public function getSourcePath();
}