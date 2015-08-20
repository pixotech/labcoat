<?php

namespace Labcoat\Patterns;

interface PatternCollectionInterface {
  public function all();
  public function get($name);
}