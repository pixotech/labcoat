<?php

namespace Labcoat\Variables;

interface ParserInterface {

  public function addHandler($prefix, callable $handler);

  public function parse(array $source);

  public function setDefaultHandler(callable $handler);
}