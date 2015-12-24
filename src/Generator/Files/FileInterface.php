<?php

namespace Labcoat\Generator\Files;

interface FileInterface {
  public function getPath();
  public function getTime();
  public function put($path);
}