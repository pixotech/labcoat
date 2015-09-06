<?php

namespace Labcoat;

interface ItemInterface {
  public function actsLikePattern();
  public function actsLikeSection();
  public function getId();
  public function getName();
  public function getNormalizedPath();
  public function getPath();
  public function getSlug();
  public function isPattern();
  public function isPseudoPattern();
  public function isSubtype();
  public function isType();
}