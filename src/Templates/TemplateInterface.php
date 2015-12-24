<?php

namespace Labcoat\Templates;

interface TemplateInterface {

  /**
   * @return \SplFileInfo
   */
  public function getFile();

  /**
   * @return mixed
   */
  public function getId();

  /**
   * @return string[]
   */
  public function getNames();

  /**
   * @param string $name
   * @return bool
   */
  public function is($name);
}