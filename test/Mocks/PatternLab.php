<?php

namespace Labcoat\Mocks;

use Labcoat\PatternLabInterface;
use RecursiveIterator;

class PatternLab implements PatternLabInterface {

  public $ignoredExtensions = [];
  public $patterns = [];
  public $render;

  public function getIgnoredExtensions() {
    return $this->ignoredExtensions;
  }

  public function copyAssetsTo($directoryPath) {
    // TODO: Implement copyAssetsTo() method.
  }

  public function getIgnoredDirectories() {
    // TODO: Implement getIgnoredDirectories() method.
  }

  public function getPatternExtension() {
    // TODO: Implement getPatternExtension() method.
  }

  public function makeDocument($patternName, $variables = NULL) {
    // TODO: Implement makeDocument() method.
  }

  public function render($patternName, $variables = NULL) {
    return $this->render;
  }

  public function getAssets() {
    // TODO: Implement getAssets() method.
  }

  public function getLayout($name) {
    // TODO: Implement getLayout() method.
  }

  public function getPattern($name) {
    return $this->patterns[$name];
  }

  public function hasLayout($name) {
    // TODO: Implement hasLayout() method.
  }

  public function getTwig() {
    // TODO: Implement getTwig() method.
  }

  public function getDataDirectory() {
    // TODO: Implement getDataDirectory() method.
  }

  public function getDefaultDirectoryPermissions() {
    // TODO: Implement getDefaultDirectoryPermissions() method.
  }

  public function getExposedOptions() {
    // TODO: Implement getExposedOptions() method.
  }

  public function getMetaDirectory() {
    // TODO: Implement getMetaDirectory() method.
  }

  public function getPatterns() {
    // TODO: Implement getPatterns() method.
  }

  public function getPatternsDirectory() {
    // TODO: Implement getPatternsDirectory() method.
  }

  public function getVendorDirectory() {
    // TODO: Implement getVendorDirectory() method.
  }

  public function setPatternsDirectory($path) {
    // TODO: Implement setPatternsDirectory() method.
  }

  public function getTypes() {
    // TODO: Implement getTypes() method.
  }

  public function getAnnotationsFile() {
    // TODO: Implement getAnnotationsFile() method.
  }

  public function getGlobalData() {
    // TODO: Implement getGlobalData() method.
  }

  public function getHiddenControls() {
    // TODO: Implement getHiddenControls() method.
  }

  public function getStyleguideAssetsDirectory() {
    // TODO: Implement getStyleguideAssetsDirectory() method.
  }

  public function getStyleguideFooter() {
    // TODO: Implement getStyleguideFooter() method.
  }

  public function getStyleguideHeader() {
    // TODO: Implement getStyleguideHeader() method.
  }

  public function getStyleguideTemplatesDirectory() {
    // TODO: Implement getStyleguideTemplatesDirectory() method.
  }

  public function isHiddenFile($path) {
    // TODO: Implement isHiddenFile() method.
  }

  public function isIgnoredFile($path) {
    // TODO: Implement isIgnoredFile() method.
  }

  public function current() {
    // TODO: Implement current() method.
  }

  public function next() {
    // TODO: Implement next() method.
  }

  public function key() {
    // TODO: Implement key() method.
  }

  public function valid() {
    // TODO: Implement valid() method.
  }

  public function rewind() {
    // TODO: Implement rewind() method.
  }

  public function count() {
    // TODO: Implement count() method.
  }

  public function hasType($name) {
    // TODO: Implement hasType() method.
  }

  public function hasChildren() {
    // TODO: Implement hasChildren() method.
  }

  public function getChildren() {
    // TODO: Implement getChildren() method.
  }
}