<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\Data\DataInterface;

/*

Pattern properties:

  Path
    The path of the pattern's styleguide page, relative to the patterns/ directory
    E.g. 00-atoms-00-logo\00-atoms-0-logo.html
    Used in the URL of the pattern's navigation item

  Name
    The name of the pattern with ordering removed, dashes converted to spaces, with all words capitalized
    Used as the label for the pattern's navigation item

  Partial
    The type (with ordering removed) + '-' + the name (with ordering removed)
    Expected to be unique
    E.g. atoms-logo
    Stored in each pattern's navigation item
    Used as the ID of the pattern in the index pages

  State
    Added as a class to the pattern's navigation item

 */

interface PatternInterface {

  /**
   * @return DataInterface
   */
  public function getData();

  /**
   * @return string
   */
  public function getDescription();

  /**
   * @return string
   */
  public function getExample();

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
   * @return array
   */
  public function getIncludingPatterns();

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
   * The partial name of the pattern
   *
   * I.e. `type-name`. Does not contain ordering. Cannot be overridden by configuration.
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
   * @return \Labcoat\PatternLab\Styleguide\Patterns\PathInterface
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
   * @return \Labcoat\PatternLab\NameInterface
   */
  public function getSubtype();

  /**
   * @return string
   */
  public function getTemplate();

  /**
   * @return array
   */
  public function getTemplateNames();

  /**
   * @return int
   */
  public function getTime();

  /**
   * @return \Labcoat\PatternLab\NameInterface
   */
  public function getType();

  /**
   * @return bool
   */
  public function hasState();

  /**
   * @return bool
   */
  public function hasSubtype();

  /**
   * @return bool
   */
  public function hasType();

  /**
   * @param PatternInterface $pattern
   * @return bool
   */
  public function includes(PatternInterface $pattern);

  /**
   * @param string $name
   * @return bool
   */
  public function matches($name);
}