<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Styleguide\Styleguide;

class Pattern implements \JsonSerializable {

  protected $id;
  protected $data = [];
  protected $displayName;
  protected $name;
  protected $file;
  protected $partial;
  protected $path;
  protected $pseudoPatterns = [];
  protected $state;
  protected $time;

  public static function makeDisplayName($name) {
    return ucwords(str_replace('-', ' ', $name));
  }

  public function __construct(PatternInterface $pattern) {
    $this->id = str_replace('/', '-', $pattern->getPath());
    $this->displayName = self::makeDisplayName($pattern->getNameWithoutDigits());
    $this->file = $pattern->getFile();
    $this->name = $pattern->getName();
    $this->partial = $pattern->getPartial();
    $this->path = $pattern->getPath();
    $this->state = $pattern->getState();
    $this->time = filemtime($this->file);

    foreach ($pattern->getData() as $data) {
      $this->data[] = $data->getFile();
    }
    foreach ($pattern->getPseudoPatterns() as $pseudo) {
      $pseudoName = $pseudo->getVariantName();
      $pseudoData = $pseudo->getData()->getFile();
      $pseudoTime = filemtime($pseudoData);
      $suffix = '-' . $pseudoName;

      $this->pseudoPatterns[] = [
        'id' => $this->id . $suffix,
        'displayName' => $this->displayName . ' ' . self::makeDisplayName($pseudoName),
        'name' => $pseudoName,
        'data' => $pseudoData,
        'path' => $this->path . $suffix,
        'partial' => $this->partial . $suffix,
        'state' => $this->state,
        'time' => $pseudoTime,
      ];
      $this->time = max($this->time, $pseudoTime);
    }
  }

  public function jsonSerialize() {
    return [
      'patternPath' => Styleguide::makePatternPath($this),
      'patternSrcPath' => $this->path,
      'patternName' => $this->getUppercaseName(),
      'patternState' => $this->state,
      'patternPartial' => $this->partial,
    ];
  }

  public function getName() {
    return $this->name;
  }

  public function getTime() {
    return $this->time;
  }
}