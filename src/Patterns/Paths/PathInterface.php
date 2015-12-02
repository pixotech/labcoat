<?php

namespace Labcoat\Patterns\Paths;

interface PathInterface {
  public function getPartial();
  public function getPath();
  public function getName();
  public function getSubtype();
  public function getType();

  /**
   * @param string $delimiter
   * @return string
   */
  public function join($delimiter);

  public function normalize();

  /**
   * @return bool
   */
  public function hasSubtype();

  /**
   * @return bool
   */
  public function hasType();
}