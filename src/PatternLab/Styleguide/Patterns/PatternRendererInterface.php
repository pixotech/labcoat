<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

interface PatternRendererInterface {

  public function render($pattern, array $vars = []);
}