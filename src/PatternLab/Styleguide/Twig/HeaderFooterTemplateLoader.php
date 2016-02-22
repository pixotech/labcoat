<?php

namespace Labcoat\PatternLab\Styleguide\Twig;

class HeaderFooterTemplateLoader extends \Twig_Loader_Array {

  public function __construct($header, $footer) {
    parent::__construct(['header' => $header, 'footer' => $footer]);
  }
}