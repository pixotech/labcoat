<?php

namespace Labcoat\Styleguide\Navigation;

interface SubtypeInterface {
  public function addPattern(PatternInterface $pattern);
  public function getLowercaseName();
  public function getName();
  public function getNameWithDashes();
  public function getUppercaseName();
}