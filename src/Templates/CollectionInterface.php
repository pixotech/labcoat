<?php

namespace Labcoat\Templates;

interface CollectionInterface {

  /**
   * @param TemplateInterface $template
   */
  public function add(TemplateInterface $template);

  /**
   * @param $name
   * @return TemplateInterface
   * @throws \OutOfBoundsException
   */
  public function find($name);
}