<?php

namespace Labcoat\Assets;

interface CopierInterface {
  public function getAssetDestination(AssetInterface $asset);
  public function copy(AssetInterface $asset);
}