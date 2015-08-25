<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\Assets;

use Labcoat\Filesystem\File;

class Asset implements AssetInterface {

  /**
   * @var string
   */
  protected $file;

  /**
   * @var string
   */
  protected $path;

  /**
   * Constructor
   *
   * @param File $file The asset file
   */
  public function __construct(File $file) {
    $this->path = $file->getPath();
    $this->file = $file->getFullPath();
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