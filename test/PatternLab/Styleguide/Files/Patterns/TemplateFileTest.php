<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\PatternLab\Patterns\Pattern;
use Labcoat\PatternLab\Styleguide\Styleguide;

class TemplateFileTest extends FileTestCase {

  public function testPath() {
    $pattern = new Pattern('name', 'type');
    $styleguide = new Styleguide();
    $dir = $styleguide->getPatternDirectoryName($pattern);
    $file = new TemplateFile($styleguide, $pattern);
    $this->assertPath("patterns/{$dir}/{$dir}.twig", $file->getPath());
  }

  public function testPut() {
    $template = 'This is the template content';
    $pattern = new Pattern('name', 'type');
    $pattern->setTemplateContent($template);
    $file = new TemplateFile(new Styleguide(), $pattern);
    $path = $this->makeFile();
    $file->put($path);
    $this->assertEquals($template, file_get_contents($path));
  }
}