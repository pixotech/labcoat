<?php

namespace Labcoat\Patterns\Paths;

interface PathInterface {

  public function getPath();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getSubtype();

  /**
   * @return string
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

  /**
   * @return PathInterface
   */
  public function normalize();
}