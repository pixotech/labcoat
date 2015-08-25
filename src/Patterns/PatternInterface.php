<?php

namespace Labcoat\Patterns;

interface PatternInterface {
  public function getName();
  public function getPath();
  public function getSubtype();
  public function getType();
  public function hasSubtype();
}