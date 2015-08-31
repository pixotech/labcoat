<?php

namespace Labcoat\Styleguide\Navigation;

interface PatternInterface {
  public function getName();
  public function getPartial();
  public function getPath();
  public function getSourcePath();
  public function getState();
}