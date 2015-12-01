<?php

namespace Labcoat\Structure;

use Labcoat\Patterns\PatternInterface;

interface SubtypeInterface extends FolderInterface {

  public function addPattern(PatternInterface $pattern);
}