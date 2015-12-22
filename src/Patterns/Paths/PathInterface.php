<?php

namespace Labcoat\Patterns\Paths;

interface PathInterface {

  public function getPath();

  /**
   * @return Name
   */
  public function getName();

  /**
   * @return Name
   */
  public function getSubtype();

  /**
   * @return Name
   */
  public function getType();

  /**
   * @param string $delimiter
   * @return string
   */
  public function join($delimiter);

  /**
   * @return bool
   */
  public function hasSubtype();

  /**
   * @return bool
   */
  public function hasType();
}