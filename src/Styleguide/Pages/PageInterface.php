<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

interface PageInterface {
  public function getContent(StyleguideInterface $styleguide);
  public function getFooterVariables(StyleguideInterface $styleguide);
  public function getHeaderVariables(StyleguideInterface $styleguide);
  public function getPath();
  public function getPatternData();
  public function getTime();
}