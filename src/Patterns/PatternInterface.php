<?php

namespace Pixo\PatternLab\Patterns;

interface PatternInterface {

  public function getData();

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
  public function hasData();
  public function matches($name);
  public function matchesPartialShorthand($shorthand);
  public function matchesPartialTemplate($template);
  public function matchesShorthand($shorthand);
  public function matchesTemplate($template);
}