<?php

namespace Labcoat\Data;

interface DataInterface {
  public function merge(DataInterface $data);
  public function toArray();
}