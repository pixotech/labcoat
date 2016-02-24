<?php

namespace Labcoat\Data;

interface DataInterface {
  public function merge(DataInterface $other);
  public function toArray();
}