<?php

namespace Labcoat\Styleguide\Patterns;

interface PatternInterface {
  public function addIncludedPattern(PatternInterface $pattern);
  public function addIncludingPattern(PatternInterface $pattern);
  public function getContent();
  public function getData();
  public function getDescription();
  public function getEscapedSourcePath();
  public function getId();
  public function getIncludedPatterns();
  public function getName();
  public function getFile();
  public function getLineagePath();
  public function getPagePath();
  public function getPartial();
  public function getPath();
  public function getSourcePath();
  public function getTemplate();
  public function getTemplatePath();
  public function getTime();
}
