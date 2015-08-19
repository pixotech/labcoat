<?php

namespace Pixo\PatternLab;

use Pixo\PatternLab\Patterns\PatternCollectionInterface;

interface PatternLabInterface {
  public function getConfiguration();
  public function getConfigurationFilePath();
  public function getPatternExtension();

  /**
   * @return PatternCollectionInterface
   */
  public function getPatterns();
  public function getPatternsDirectoryPath();
  public function getPatternTypes();
  public function getSourceDirectoryPath();
  public function hasConfiguration();
  public function loadConfiguration();
}