<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Patterns\Pattern;

class TemplateFileTest extends FileTestCase {

  public function testPath() {
    $dir = 'pattern-id';
    $pattern = new Pattern();
    $pattern->styleguideDirectoryName = $dir;
    $file = new TemplateFile($pattern);
    $this->assertPath("patterns/{$dir}/{$dir}.twig", $file->getPath());
  }

  public function testPut() {
    $template = 'This is the template content';
    $pattern = new Pattern();
    $pattern->templateContent = $template;
    $file = new TemplateFile($pattern);
    $path = $this->makeFile();
    $file->put($path);
    $this->assertEquals($template, file_get_contents($path));
  }
}