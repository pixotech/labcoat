<?php

namespace Labcoat\Structure;

use Labcoat\Patterns\PatternInterface;

interface FolderInterface {

  /**
   * @param PatternInterface $pattern
   */
  public function addPattern(PatternInterface $pattern);

  /**
   * @param PatternInterface[] $patterns
   */
  public function addPatterns(array $patterns);

  /**
   * @return string
   */
  public function getName();

  /**
   * @return PatternInterface[]
   */
  public function getPatterns();
}