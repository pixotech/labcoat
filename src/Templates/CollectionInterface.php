<?php

namespace Labcoat\Templates;

interface CollectionInterface extends \Twig_LoaderInterface {

  /**
   * @param TemplateInterface $template
   */
  public function add(TemplateInterface $template);

  /**
   * @param string $name
   * @return TemplateInterface
   * @throws \OutOfBoundsException
   */
  public function find($name);

  /**
   * @return TemplateInterface[]
   */
  public function getTemplates();
}