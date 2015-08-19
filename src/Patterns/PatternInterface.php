<?php

namespace Pixo\PatternLab\Patterns;

interface PatternInterface {

  /**
   * @return \SplFileInfo
   */
  public function getFile();
  public function getName();
  public function getShorthand();
  public function getSubType();
  public function getTemplate();
  public function getTemplateWithoutExtension();
  public function getType();
  public function matches($name);
  public function matchesPartialShorthand($shorthand);
  public function matchesPartialTemplate($template);
  public function matchesShorthand($shorthand);
  public function matchesTemplate($template);
}