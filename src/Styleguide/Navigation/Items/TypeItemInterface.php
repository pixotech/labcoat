<?php

namespace Labcoat\Styleguide\Navigation\Items;

use Labcoat\Styleguide\Navigation\Items\ItemInterface;

interface TypeItemInterface extends ItemInterface {
  public function getSubtype();
  public function getType();
}