<?php

namespace Pixo\PatternLab\Patterns;

interface PatternCollectionInterface {
  public function all();
  public function get($name);
}