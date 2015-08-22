<?php

namespace Labcoat;

use Commando\Command;
use Labcoat\Assets\Copier;

require_once __DIR__ . '/vendor/autoload.php';

$command = new Command();

$command->option()
  ->require()
  ->describedAs("The operation to perform (copy)");

$command->option("colors")
  ->aka("c")
  ->describedAs("Colorize output")
  ->boolean();

$command->option("destination")
  ->aka("dest")
  ->aka("d")
  ->describedAs("The directory to which files should be copied");

$command->option("force")
  ->aka("f")
  ->describedAs("Override all existing files")
  ->boolean();

$command->option("patternlab")
  ->aka("pl")
  ->aka("p")
  ->require()
  ->describedAs("The path to the Pattern Lab installation");

$command->option("simulate")
  ->aka("sim")
  ->aka("s")
  ->describedAs("Simulate")
  ->boolean();

switch ($command[0]) {

  case 'copy':
    $patternlab = new \Labcoat\PatternLab($command['patternlab']);
    if (!$destination = $command['destination']) {
      \cli\line("Please provide a destination directory");
      die();
    }
    try {
      $copier = new Copier($command['destination']);
      $force = $command['f'];
      $simulate = $command['s'];
      foreach ($patternlab->getAssets() as $asset) {
        $status = $copier->getAssetStatus($asset);
        $needsUpdate = $force || in_array($status,  [Copier::STATUS_MISSING, Copier::STATUS_NEEDS_UPDATE]);
        if (!$simulate && $needsUpdate) $status = $copier->copy($asset);
        $message = sprintf("%s %s", str_pad(strtoupper($status), 12), $asset->getPath());
        if ($command['colors']) $message = colorize_message($message, $status);
        \cli\line($message);
      }
    }
    catch (\Exception $e) {
      \cli\line($e->getMessage());
      die();
    }
    break;

  default:
    \cli\line("Unknown operation");
}

function colorize_message($message, $status) {
  \cli\Colors::enable();
  switch ($status) {
    case Copier::STATUS_UPDATED:
      $color = '%2';
      break;
    case Copier::STATUS_MISSING:
    case Copier::STATUS_NEEDS_UPDATE:
      $color = '%y';
      break;
    case Copier::STATUS_FAILED:
    case Copier::STATUS_READONLY:
      $color = '%1';
      break;
    case Copier::STATUS_UP_TO_DATE:
      $color = '%g';
      break;
    default:
      $color = '%n';
  }
  return \cli\Colors::colorize($color . $message . '%n');
}