<?php

namespace Labcoat\Styleguide\Html;

use Labcoat\Html\Document as HtmlDocument;
use Labcoat\Styleguide\StyleguideInterface;

/*

<!DOCTYPE html>
<html class="{{ htmlClass }}">
	<head>
		<title>{{ title }}</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width" />

		<link rel="stylesheet" href="../../css/style.css?{{ cacheBuster }}" media="all" />

		<!-- Begin Pattern Lab (Required for Pattern Lab to run properly) -->
		{{ patternLabHead | raw }}
		<!-- End Pattern Lab -->

	</head>
	<body class="{{ bodyClass }}">

  ---

	<!--DO NOT REMOVE-->
	{{ patternLabFoot | raw }}

	</body>
</html>

 */

class Document extends HtmlDocument {

  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide) {
    parent::__construct();
    $this->styleguide = $styleguide;
  }

  protected function getCacheBuster() {
    return $this->styleguide->getCacheBuster();
  }

  protected function getPatternData() {

  }

  protected function makePatternLabFooter() {
    $data = [
      'cacheBuster' => $this->getCacheBuster(),
      'patternData' => json_encode($this->getPatternData()),
    ];
    return $this->render('partials/general-footer', $data);
  }

  protected function makePatternLabHeader() {
    $data = [
      'cacheBuster' => $this->getCacheBuster(),
    ];
    return $this->render('partials/general-header', $data);
  }

  protected function render($template, array $vars = []) {
    return $this->styleguide->render($template, $vars);
  }
}