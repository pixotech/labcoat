<?php

namespace Labcoat;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Sections\SectionInterface;
use Labcoat\Patterns\PseudoPatternInterface;
use Labcoat\Sections\SubtypeInterface;
use Labcoat\Sections\TypeInterface;

class Item implements ItemInterface {

  /**
   * @var string
   */
  protected $id;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $normalizedPath;

  /**
   * @var string
   */
  protected $path;

  /**
   * @var string
   */
  protected $slug;

  public function __toString() {
    return $this->path;
  }

  public function actsLikePattern() {
    return $this instanceof PatternInterface;
  }

  public function actsLikeSection() {
    return $this instanceof SectionInterface;
  }

  public function getId() {
    return $this->id;
  }

  public function getName() {
    if (!isset($this->name)) {
      $this->name = preg_replace('/[-]+/', ' ', $this->getSlug());
    }
    return $this->name;
  }

  public function getNormalizedPath() {
    if (!isset($this->normalizedPath)) {
      $this->normalizedPath = PatternLab::normalizePath($this->getPath());
    }
    return $this->normalizedPath;
  }

  public function getPath() {
    return $this->path;
  }

  public function getSlug() {
    if (!isset($this->slug)) {
      $this->slug = basename($this->getNormalizedPath());
    }
    return $this->slug;
  }

  public function isPattern() {
    return $this->actsLikePattern() && !$this->isPseudoPattern();
  }

  public function isPseudoPattern() {
    return $this instanceof PseudoPatternInterface;
  }

  public function isSubtype() {
    return $this instanceof SubtypeInterface;
  }

  public function isType() {
    return $this instanceof TypeInterface;
  }
}