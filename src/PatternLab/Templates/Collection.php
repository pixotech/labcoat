<?php

namespace Labcoat\PatternLab\Templates;

use Labcoat\PatternLab\PatternLab;
use Labcoat\PatternLab\Patterns\Pattern;

class Collection extends \Labcoat\Templates\Collection implements CollectionInterface {

  public function getPatterns() {
    $patterns = [];
    foreach ($this->getTemplates() as $template) {
      /** @var TemplateInterface $template */
      $patterns[] = $this->makePattern($template);
      foreach ($template->getVariants() as $variant => $data) {
        $patterns[] = $this->makePseudoPattern($template, $variant, $data);
      }
    }
    return $patterns;
  }

  protected function makePattern(TemplateInterface $template) {
    list ($name, $type, $subtype) = PatternLab::splitPath($template->getId());
    $pattern = new Pattern($name, $type, $subtype);
    $pattern->setLabel(PatternLab::makeLabel($name));
    return $pattern;
  }

  protected function makePseudoPattern(TemplateInterface $template, $name, $data) {
    list ($pattern, $type, $subtype) = PatternLab::splitPath($template->getId());
    $variantName = "{$pattern}-{$name}";
    $pattern = new Pattern($variantName, $type, $subtype);
    $pattern->setLabel(PatternLab::makeLabel($variantName));
    return $pattern;
  }
}