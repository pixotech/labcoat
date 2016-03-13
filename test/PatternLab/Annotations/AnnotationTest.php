<?php

namespace Labcoat\PatternLab\Annotations;

class AnnotationTest extends \PHPUnit_Framework_TestCase {

  public function testJson() {
    $selector = 'selector';
    $title = 'title';
    $comment = 'comment';
    $annotation = new Annotation($selector, $title, $comment);
    $json = $annotation->jsonSerialize();
    $this->assertArrayHasKey('el', $json);
    $this->assertEquals($selector, $json['el']);
    $this->assertArrayHasKey('title', $json);
    $this->assertEquals($title, $json['title']);
    $this->assertArrayHasKey('comment', $json);
    $this->assertEquals($comment, $json['comment']);
  }
}