<?php

namespace Labcoat\Patterns;

use Labcoat\Data\DataInterface;
use Labcoat\Patterns\Configuration\ConfigurationInterface;

interface PatternInterface {

  /**
   * @return ConfigurationInterface
   */
  public function getConfiguration();

  /**
   * @return string
   */
  public function getFile();

  /**
   * The ID of this pattern
   *
   * By default, IDs are derived from the pattern path, and not guaranteed to be unique. May contain ordering. Can be
   * overridden by configuration.
   *
   * @return string
   */
  public function getId();

  /**
   * @return array
   */
  public function getIncludedPatterns();

  /**
   * The human-readable name of the pattern
   *
   * Derived from the pattern name by default. Does not contain ordering. Can be overridden by configuration.
   *
   * @return string
   */
  public function getLabel();

  /**
   * The name of the pattern
   *
   * Derived from the template path by default. May contain ordering. Can be overridden by configuration.
   *
   * @return string
   */
  public function getName();

  /**
   * The path to the style guide page
   *
   * Equivalent to `id/id.html`. Cannot be overridden by configuration.
   *
   * @return string
   */
  public function getPagePath();

  /**
   * The partial name of the pattern
   *
   * Defaults to `type-name`. Does not contain ordering. Can be overridden by configuration.
   *
   * @return string
   */
  public function getPartial();

  /**
   * The pattern path
   *
   * A path object, representing the path of the template relative to the patterns directory, with the file extension
   * removed. Default source for pattern metadata such as name, type, and subtype. May contain ordering. Cannot be
   * overridden by configuration.
   *
   * @return \Labcoat\Patterns\Paths\PathInterface
   */
  public function getPath();

  /**
   * @return PseudoPatternInterface[]
   */
  public function getPseudoPatterns();

  /**
   * The pattern's state of development
   *
   * Contrary to standard Pattern Lab, this is NOT derived from the path, but is only configurable.
   *
   * @return string
   */
  public function getState();

  /**
   * @return \Labcoat\Structure\SubtypeInterface
   */
  public function getSubtype();

  /**
   * @return string
   */
  public function getTemplate();

  /**
   * @return int
   */
  public function getTime();

  /**
   * @return \Labcoat\Structure\TypeInterface
   */
  public function getType();

  /**
   * @return bool
   */
  public function hasSubtype();

  /**
   * @return bool
   */
  public function hasType();

  public function render(DataInterface $data = null);

  /**
   * @param ConfigurationInterface $configurationInterface
   */
  public function setConfiguration(ConfigurationInterface $configurationInterface);
}