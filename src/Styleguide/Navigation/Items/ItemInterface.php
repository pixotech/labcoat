<?php

namespace Labcoat\Styleguide\Navigation\Items;

interface ItemInterface {
  public function getName();
  public function getPartial();
  public function getPath();
}