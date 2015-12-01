<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Paths\Segment;
use Labcoat\Structure\TypeInterface as SourceTypeInterface;

class Type implements \JsonSerializable, TypeInterface {

  protected $name;
  protected $patterns = [];
  protected $subtypes = [];

  /**
   * @var TypeInterface
   */
  protected $type;

  public function __construct(SourceTypeInterface $type) {
    $this->name = $type->getName();
  }

  public function getLowercaseName() {
    return str_replace('-', ' ', $this->getNameWithDashes());
  }

  public function getName() {
    return $this->name;
  }

  public function getNameWithDashes() {
    return Segment::stripDigits($this->getName());
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }

  public function jsonSerialize() {
    $type = Segment::stripDigits($this->name);
    $items = array_values($this->patterns);
    if (!empty($this->subtypes)) {
      $items[] = [
        "patternPath" => "{$this->name}/index.html",
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
    $path = explode(DIRECTORY_SEPARATOR, $pattern->getPath());
    if (count($path) > 2) {
      $this->getSubtype($path[1])->addPattern($pattern);
    }
    else {
      $this->patterns[$pattern->getSlug()] = new Pattern($pattern);
      foreach ($pattern->getPseudoPatterns() as $pseudo) {
        $this->patterns[$pseudo->getSlug()] = new Pattern($pseudo);
      }
      ksort($this->patterns);
    }
  }

  public function addSubtype(\Labcoat\Structure\SubtypeInterface $subtype) {
    $name = array_pop(explode(DIRECTORY_SEPARATOR, $subtype->getName()));
    $this->subtypes[$name] = new Subtype($subtype);
    ksort($this->subtypes);
  }

  /**
   * @param $name
   * @return SubtypeInterface
   */
  public function getSubtype($name) {
    return $this->subtypes[$name];
  }
}
