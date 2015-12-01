<?php

namespace Labcoat\Structure;

use Labcoat\Patterns\PatternInterface;

interface FolderInterface {
  public function addPattern(PatternInterface $pattern);
  public function addPatterns(array $patterns);
  public function getName();
  public function getPatterns();
}