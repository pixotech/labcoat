<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\PatternLabInterface;

class PatternWriter {

  protected $patternlab;

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
  }

  public function write() {
    $path          = $patternStoreData["pathDash"];
    $pathName      = (isset($patternStoreData["pseudo"])) ? $patternStoreData["pathOrig"] : $patternStoreData["pathName"];

    // modify the pattern mark-up
    $markup        = $patternStoreData["code"];
    $markupEncoded = htmlentities($markup,ENT_COMPAT,"UTF-8");
    $markupFull    = $patternStoreData["header"].$markup.$patternStoreData["footer"];
    $markupEngine  = htmlentities(file_get_contents($patternSourceDir."/".$pathName.".".$patternExtension),ENT_COMPAT,"UTF-8");

    // if the pattern directory doesn't exist create it
    if (!is_dir($patternPublicDir."/".$path)) {
      mkdir($patternPublicDir."/".$path);
    }

    // write out the various pattern files
    file_put_contents($patternPublicDir."/".$path."/".$path.".html",$markupFull);
    if (!$exportFiles) {
      file_put_contents($patternPublicDir."/".$path."/".$path.".escaped.html",$markupEncoded);
      file_put_contents($patternPublicDir."/".$path."/".$path.".".$patternExtension,$markupEngine);
    }
  }
}