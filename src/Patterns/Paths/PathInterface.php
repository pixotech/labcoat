<?php

namespace Labcoat\Patterns\Paths;

interface PathInterface {
  public function getPartial();
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
   * @return PathInterface
   */
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