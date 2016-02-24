<?php

namespace Labcoat\Templates;

interface TemplateInterface {

  /**
   * @return \SplFileInfo
   */
  public function getFile();

  /**
   * @return string
   */
  public function getId();

  /**
   * @return \DateTime
   */
  public function getTime();

  /**
   * @param string $name
   * @return bool
   */
  public function is($name);
}