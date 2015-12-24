<?php

namespace Labcoat\Templates;

interface CollectionInterface {
  public function add(TemplateInterface $template);
  public function find($name);
}