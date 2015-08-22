<?php

namespace Labcoat\Patterns;

interface PatternInterface {

  public function getData();

  /**
   * @return \SplFileInfo
   */
  public function getFile();
  public function getPath();
  public function getShorthand();
  public function hasData();
}