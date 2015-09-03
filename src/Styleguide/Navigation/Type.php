<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\PatternLab;
use Labcoat\Patterns\PatternTypeInterface;

class Type implements \JsonSerializable, TypeInterface {

  protected $name;
  protected $patterns = [];
  protected $subtypes = [];

  /**
   * @var PatternTypeInterface
   */
  protected $type;

  public function __construct(PatternTypeInterface $type) {
    #$this->type = $type;
    $this->name = $type->getName();
  }

  public function getLowercaseName() {
    return str_replace('-', ' ', $this->getNameWithDashes());
  }

  public function getName() {
    return $this->name;
  }

  public function getNameWithDashes() {
    return PatternLab::stripDigits($this->getName());
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }

  public function jsonSerialize() {
    $type = PatternLab::stripDigits($this->name);
    $items = array_values($this->patterns);
    if (!empty($this->subtypes)) {
      $items[] = [
        "patternPath" => "{$this->type}/index.html",
        "patternName" => "View All",
        "patternType" => $this->name,
        "patternSubtype" => "all",
        "patternPartial" => "viewall-{$type}-all",
      ];
    }
    return [
      'patternTypeLC' => $this->getLowercaseName(),
      'patternTypeUC' => $this->getUppercaseName(),
      'patternType' => $this->getName(),
      'patternTypeDash' => $this->getNameWithDashes(),
      'patternTypeItems' => array_values($this->subtypes),
      'patternItems' => $items,
    ];
  }

  public function addPattern(\Labcoat\Patterns\PatternInterface $pattern) {
    if ($pattern->hasSubtype()) {
      $this->getSubtype($pattern->getSubType())->addPattern($pattern);
    }
    else {
      $this->patterns[$pattern->getName()] = new Pattern($pattern);
      foreach ($pattern->getPseudoPatterns() as $pseudo) {
        $this->patterns[$pseudo->getName()] = new Pattern($pseudo);
      }
    }
  }

  public function addSubtype(SubtypeInterface $subtype) {
    $this->subtypes[$subtype->getName()] = $subtype;
  }

  /**
   * @param $name
   * @return SubtypeInterface
   */
  public function getSubtype($name) {
    return $this->subtypes[$name];
  }
}