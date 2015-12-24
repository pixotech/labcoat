<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Patterns\Pattern;

class TemplateFileTest extends FileTestCase {

  public function testPath() {
    $id = 'pattern-id';
    $pattern = new Pattern();
    $pattern->id = $id;
    $file = new TemplateFile($pattern);
    $this->assertPath("patterns/{$id}/{$id}.twig", $file->getPath());
  }

  public function testPut() {
    $templateFile = $this->makeFile();
    $template = 'This is the template content';
    file_put_contents($templateFile, $template);
    $pattern = new Pattern();
    $pattern->file = $templateFile;
    $file = new TemplateFile($pattern);
    $path = $this->makeFile();
    $file->put($path);
    $this->assertEquals($template, file_get_contents($path));
  }

  public function testTime() {
    $time = time();
    $pattern = new Pattern();
    $pattern->time = $time;
    $file = new TemplateFile($pattern);
    $this->assertEquals($time, $file->getTime());
  }
}