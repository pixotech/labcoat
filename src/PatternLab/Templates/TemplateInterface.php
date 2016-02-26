<?php

namespace Labcoat\PatternLab\Templates;

interface TemplateInterface extends \Labcoat\Templates\TemplateInterface {

  /**
   * @return array
   */
  public function getData();

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
   * @return array
   */
  public function getVariants();

  /**
   * @return bool
   */
  public function hasData();

  /**
   * @return bool
   */
  public function hasSubtype();

  /**
   * @return bool
   */
  public function hasVariants();
}