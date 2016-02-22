<?php

namespace Labcoat\PatternLab;

interface PatternInterface {

  /**
   * @return string
   */
  public function getFile();

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
  public function getPath();

  /**
   * @return string
   */
  public function getType();
}