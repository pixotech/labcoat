<?php

namespace Labcoat\Html;

interface DocumentInterface {
  public function addMeta($name, $content);
  public function addScript($script);
  public function addStyles($styles);
  public function getBody();
  public function getThemeColor();
  public function getTitle();
  public function includeScript($url);
  public function includeStylesheet($url);
  public function setBaseHref($href);
  public function setBody($body);
  public function setThemeColor($themeColor);
  public function setTitle($title);
}