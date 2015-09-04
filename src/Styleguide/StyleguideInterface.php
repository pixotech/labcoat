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
  public function getConfig();

  /**
   * @return array
   */
  public function getControls();

  /**
   * @return array
   */
  public function getGlobalData();

  /**
   * @return array
   */
  public function getIndexPaths();

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
   * @return array
   */
  public function getPatternPaths();

  /**
   * @return array
   */
  public function getPlugins();

  /**
   * @return \Twig_Environment
   */
  public function getTwig();

  /**
   * @return string
   */
  public function renderPattern(PatternInterface $pattern, array $data = []);
}