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
  public function getId();

  /**
   * @return string
   */
  public function getLabel();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getPagePath();

  /**
   * @return PatternInterface[]
   */
  public function getPatterns();
}