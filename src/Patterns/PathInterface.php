<?php

namespace Labcoat\Patterns;

interface PathInterface {
  public function getPartial();
  public function getPath();
  public function getSlug();
  public function getState();
  public function getSubtype();
  public function getType();
}