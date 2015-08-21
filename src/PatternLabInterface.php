<?php

namespace Labcoat;

use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternCollectionInterface;

interface PatternLabInterface {
  public function copyAssetsTo($directoryPath);
  public function makeDocument($patternName, array $variables = []);
  public function render($patternName, array $variables = []);
}