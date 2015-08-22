<?php

namespace Labcoat;

use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternCollectionInterface;

interface PatternLabInterface {
  public function copyAssetsTo($directoryPath);
  public function getIgnoredDirectories();
  public function getIgnoredExtensions();
  public function getPatternExtension();
  public function getPatternsDirectory();
  public function makeDocument($patternName, $variables = null);
  public function render($patternName, $variables = null);
}