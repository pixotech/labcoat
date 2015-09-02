<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\Assets;

class Asset implements AssetInterface {

  /**
   * @var string
   */
  protected $file;

  /**
   * @var string
   */
  protected $path;

  public function __construct($path, $file) {
    $this->path = $path;
    $this->file = $file;
  }

  /**
   * {@inheritDoc}
   */
  public function getFile() {
    return $this->file;
  }

  /**
   * @inheritDoc
   */
  public function getPath() {
    return $this->path;
  }
}