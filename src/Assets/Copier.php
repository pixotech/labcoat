<?php

namespace Labcoat\Assets;

class Copier implements CopierInterface {

  const STATUS_FAILED = 'failed';
  const STATUS_MISSING = 'missing';
  const STATUS_NEEDS_UPDATE = 'needs update';
  const STATUS_READONLY = 'readonly';
  const STATUS_UP_TO_DATE = 'up-to-date';
  const STATUS_UPDATED = 'updated';

  protected $destination;

  public function __construct($destination) {
    if (!is_dir($destination)) throw new \InvalidArgumentException("Not a directory: $destination");
    if (!is_writable($destination)) throw new \InvalidArgumentException("Not writable: $destination");
    $this->destination = rtrim($destination, DIRECTORY_SEPARATOR);
  }

  public function copy(AssetInterface $asset, $mode = 0777) {
    $destinationPath = $this->getAssetDestination($asset);
    if (!is_dir(dirname($destinationPath))) {
      if (!mkdir(dirname($destinationPath), $mode, true)) return self::STATUS_FAILED;
    }
    if (!copy($asset->getFile(), $destinationPath)) return self::STATUS_FAILED;
    chmod($destinationPath, $mode);
    return self::STATUS_UPDATED;
  }

  public function getAssetDestination(AssetInterface $asset) {
     return $this->destination . DIRECTORY_SEPARATOR . $asset->getPath();
  }

  public function getAssetStatus(AssetInterface $asset) {
    $destination = $this->getAssetDestination($asset);
    if (!is_file($destination)) return self::STATUS_MISSING;
    if (!is_writable($destination)) return self::STATUS_READONLY;
    $source = $asset->getFile();
    return filemtime($source) > filemtime($destination) ? self::STATUS_NEEDS_UPDATE : self::STATUS_UP_TO_DATE;
  }
}