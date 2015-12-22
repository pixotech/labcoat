<?php

namespace Labcoat\Templates;

interface TemplateInterface {

  /**
   * @return \SplFileInfo
   */
  public function getFile();

  /**
   * @return string[]
   */
  public function getNames();
}