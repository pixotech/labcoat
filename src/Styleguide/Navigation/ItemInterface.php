<?php

namespace Labcoat\Styleguide\Navigation;

interface ItemInterface {
  public function getName();
  public function getPartial();
  public function getPath();
}