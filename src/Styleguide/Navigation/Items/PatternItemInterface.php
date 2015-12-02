<?php

namespace Labcoat\Styleguide\Navigation\Items;

use Labcoat\Styleguide\Navigation\Items\ItemInterface;

interface PatternItemInterface extends ItemInterface {
  public function getState();
}