<?php

namespace Labcoat\Styleguide\Files;

interface DynamicFileInterface extends FileInterface {
  public function getContents();
}