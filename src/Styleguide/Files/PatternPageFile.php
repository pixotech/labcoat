<?php

namespace Labcoat\Styleguide\Files;

class PatternPageFile extends PatternFile implements PatternPageFileInterface {

  public function getContents() {
    $pattern = $this->render();
    $data = $this->getPatternData();
    $header = $this->styleguide->makeHeader($data);
    $data['patternData'] = $this->makeFooterPatternData();
    $footer = $this->styleguide->makeFooter($data);
    return $header . $pattern . $footer;
  }

  public function getPath() {
    $path = $this->pattern->getStyleguidePathName();
    return $this->makePath(['patterns', $path, "$path.html"]);
  }

  protected function getBreadcrumb() {
    $crumb = [$this->pattern->getType()];
    if ($this->pattern->hasSubtype()) $crumb[] = $this->pattern->getSubtype();
    return implode(' &gt; ', $crumb);
  }

  protected function makeFooterPatternData() {
    $data = [];
    $data['cssEnabled'] = false;
    $data['lineage'] = [];
    $data['lineageR'] = [];
    $data['patternBreadcrumb'] = $this->getBreadcrumb();
    $data['patternDesc'] = '';
    $data['patternExtension'] = $this->getPatternLab()->getPatternExtension();
    $data['patternName'] = strtolower($this->pattern->getDisplayName());
    $data['patternPartial'] = $this->pattern->getPartial();
    $data['patternState'] = '';
    $data['extraOutput'] = [];
    return json_encode($data);
  }
}