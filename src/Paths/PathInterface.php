<?php

namespace Labcoat\Paths;

interface PathInterface {
  public function getPartial();
  public function getPath();
  public function getName();
  public function getState();
  public function getSubtype();
  public function getType();

  /**
   * @return bool
   */
  public function hasSubtype();

  /**
   * @return bool
   */
  public function hasType();
}