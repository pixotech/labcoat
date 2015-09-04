<?php

namespace Labcoat;

interface HasItemsInterface extends \RecursiveIterator {
  public function count();
}