<?php

namespace Labcoat\Html;

interface ElementInterface {

  public function __toString();

  public function getAttributes();

  public function getContent();

  public function getName();

  public function isSelfClosing();
}