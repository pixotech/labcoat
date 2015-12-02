<?php

namespace Labcoat\Styleguide\Navigation;

interface TypeItemInterface extends ItemInterface {
  public function getSubtype();
  public function getType();
}