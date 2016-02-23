<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

interface PageRendererInterface {

  public function renderPage($content, array $data = []);

  public function renderPatterns(array $patterns);
}