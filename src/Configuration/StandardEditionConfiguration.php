<?php

namespace Labcoat\Configuration;

use Labcoat\PatternLab;
use Symfony\Component\Yaml\Yaml;

class StandardEditionConfiguration extends Configuration {

  public function __construct($dir) {
    $configPath = PatternLab::makePath([$dir, 'config', 'config.yml']);
    if (is_file($configPath)) {
      $seConfig = Yaml::parse(file_get_contents($configPath));

      if (!empty($seConfig['sourceDir'])) {
        $sourceDir = PatternLab::makePath([$dir, $seConfig['sourceDir']]);
        if (is_dir($sourceDir)) {

          $this->addAssetDirectory($sourceDir);

          $patternsDir = PatternLab::makePath([$sourceDir, '_patterns']);
          if (is_dir($patternsDir)) {
            $this->setPatternsDirectory($patternsDir);
          }

          $dataDir = PatternLab::makePath([$sourceDir, '_data']);
          if (is_dir($dataDir)) {
            foreach (glob(PatternLab::makePath([$dataDir, '*.json'])) as $path) {
              if (basename($path) == 'listitems.json') $this->addListItems($path);
              else $this->addGlobalData($path);
            }
          }

          $annotationsPath = PatternLab::makePath([$sourceDir, '_annotations', 'annotations.js']);
          if (is_file($annotationsPath)) {
            $this->setAnnotationsFile($annotationsPath);
          }

          $headerPath = PatternLab::makePath([$sourceDir, '_meta', '_00-head.twig']);
          if (is_file($headerPath)) {
            $this->setStyleguideHeader($headerPath);
          }

          $footerPath = PatternLab::makePath([$sourceDir, '_meta', '_01-foot.twig']);
          if (is_file($footerPath)) {
            $this->setStyleguideFooter($footerPath);
          }
        }
      }

      if (!empty($seConfig['packagesDir'])) {
        $packagesDir = PatternLab::makePath([$dir, $seConfig['packagesDir']]);
        if (is_dir($packagesDir)) {

          $assetsDir = PatternLab::makePath([$packagesDir, 'pattern-lab', 'styleguidekit-assets-default', 'dist']);
          if (is_dir($assetsDir)) {
            $this->addStyleguideAssetDirectory($assetsDir);
          }

          if (!empty($seConfig['styleguideKit'])) {
            $templatesDir = PatternLab::makePath([$packagesDir, $seConfig['styleguideKit'], 'views']);
            if (is_dir($templatesDir)) {
              $this->setStyleguideTemplatesDirectory($templatesDir);
            }
          }
        }
      }

      if (!empty($seConfig['id'])) {
        $this->setIgnoredDirectories($seConfig['id']);
      }

      if (!empty($seConfig['ie'])) {
        $this->setIgnoredExtensions($seConfig['ie']);
      }

      if (!empty($seConfig['ishControlsHide'])) {
        $this->setHiddenControls($seConfig['ishControlsHide']);
      }

      if (!empty($seConfig['patternExtension'])) {
        $this->setPatternExtension($seConfig['patternExtension']);
      }
    }
  }
}