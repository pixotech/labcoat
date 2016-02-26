<?php

namespace Labcoat\Templates;

interface TemplateInterface {

  /**
   * @return array
   */
  public function getDependencies();

  /**
   * @return \SplFileInfo
   */
  public function getFile();

  /**
   * @return array
   */
  public function getIncludedTemplates();

  /**
   * @return string
   */
  public function getId();

  /**
   * @return string
   */
  public function getParent();

  /**
   * @return \DateTime
   */
  public function getTime();

  /**
   * @return bool
   */
  public function hasParent();

  /**
   * @param string $name
   * @return bool
   */
  public function is($name);

  /**
   * @return bool
   */
  public function isValid();
}