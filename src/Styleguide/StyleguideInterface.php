<?php

namespace Labcoat\Styleguide;

use Labcoat\Styleguide\Patterns\PatternInterface;

interface StyleguideInterface {

  /**
   * @param string $directory
   */
  public function generate($directory);

  /**
   * @return string
   */
  public function getCacheBuster();

  /**
   * @return array
   */
  public function getGlobalData();

  /**
   * @param $id
   * @return PatternInterface
   */
  public function getPattern($id);

  /**
   * @return \Labcoat\PatternLabInterface
   */
  public function getPatternLab();

  /**
   * @return \Twig_Environment
   */
  public function getTwig();

  /**
   * @return string
   */
  public function renderPattern(PatternInterface $pattern, array $data = []);
}