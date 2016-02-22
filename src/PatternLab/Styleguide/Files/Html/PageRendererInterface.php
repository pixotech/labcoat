<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

interface PageRendererInterface {

  public function __invoke($content, array $data = []);
}