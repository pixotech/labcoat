<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Mocks\PatternLab;
use Labcoat\Mocks\Patterns\Pattern;
use Labcoat\Mocks\Structure\Subtype;
use Labcoat\Mocks\Structure\Type;

class DataFileTest extends \PHPUnit_Framework_TestCase {

  # Navigation: Types

  public function testNavItemTypeName() {
    $name = 'type';
    $type = new Type();
    $type->name = $name;
    $nav = DataFile::makeNavType($type);
    $this->assertEquals($name, $nav['patternType']);
  }

  public function testNavItemTypeLowercaseName() {
    $name = 'type';
    $type = new Type();
    $type->name = $name;
    $nav = DataFile::makeNavType($type);
    $this->assertEquals('type', $nav['patternTypeLC']);
  }

  public function testNavItemTypeUppercaseName() {
    $label = 'Type Name';
    $type = new Type();
    $type->label = $label;
    $nav = DataFile::makeNavType($type);
    $this->assertEquals($label, $nav['patternTypeUC']);
  }

  # Navigation: Subtypes

  public function testNavItemSubtypeName() {
    $name = 'subtype';
    $subtype = new Subtype();
    $subtype->name = $name;
    $nav = DataFile::makeNavSubtype($subtype);
    $this->assertEquals($name, $nav['patternSubtype']);
  }

  public function testNavItemSubtypeLowercaseName() {
    $name = 'subtype';
    $subtype = new Subtype();
    $subtype->name = $name;
    $nav = DataFile::makeNavSubtype($subtype);
    $this->assertEquals($name, $nav['patternSubtypeLC']);
  }

  public function testNavItemSubtypeUppercaseName() {
    $label = 'Subtype Label';
    $subtype = new Subtype();
    $subtype->label = $label;
    $nav = DataFile::makeNavSubtype($subtype);
    $this->assertEquals($label, $nav['patternSubtypeUC']);
  }

  # Navigation: Patterns

  public function testNavItemPatternName() {
    $name = 'Pattern Name';
    $pattern = new Pattern();
    $pattern->label = $name;
    $nav = DataFile::makeNavPattern($pattern);
    $this->assertEquals($name, $nav['patternName']);
  }




  public function testNavItems() {
    $patternlab = new PatternLab();
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertCount(1, $nav);
    $this->assertArrayHasKey('patternTypes', $nav);
    $this->assertTrue(is_array($nav['patternTypes']));
  }

  public function testNavItemTypes() {
    $patternlab = new PatternLab();
    $patternlab->types[] = $type = $this->makeType('type');
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertCount(1, $nav['patternTypes']);
  }

  public function testNavItemSubtypes() {
    $patternlab = new PatternLab();
    $type = new Type();
    $subtype = new Subtype();
    $type->subtypes[] = $subtype;
    $patternlab->types[] = $type;
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertCount(1, $nav['patternTypes'][0]['patternTypeItems']);
  }

  public function testNavItemTypePatterns() {
    $patternlab = new PatternLab();
    $type = new Type();
    $pattern = new Pattern();
    $type->patterns[] = $pattern;
    $patternlab->types[] = $type;
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertCount(1, $nav['patternTypes'][0]['patternItems']);
  }

  public function testNavItemTypePatternsIncludeSubtypeIndexes() {
    $patternlab = new PatternLab();
    $type = new Type();
    $subtype = new Subtype();
    $type->subtypes[] = $subtype;
    $pattern = new Pattern();
    $type->patterns[] = $pattern;
    $patternlab->types[] = $type;
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertCount(2, $nav['patternTypes'][0]['patternItems']);
  }

  public function testNavItemPatternPagePath() {
    $path = 'path-to-the-pattern';
    $patternlab = new PatternLab();
    $type = new Type();
    $pattern = new Pattern();
    $pattern->pagePath = $path;
    $type->patterns[] = $pattern;
    $patternlab->types[] = $type;
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertEquals($path, $nav['patternTypes'][0]['patternItems'][0]['patternPath']);
  }

  public function testNavItemPatternPartial() {
    $partial = 'path-to-the-pattern';
    $patternlab = new PatternLab();
    $type = new Type();
    $pattern = new Pattern();
    $pattern->partial = $partial;
    $type->patterns[] = $pattern;
    $patternlab->types[] = $type;
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertEquals($partial, $nav['patternTypes'][0]['patternItems'][0]['patternPartial']);
  }

  public function testNavItemPatternState() {
    $state = 'state';
    $patternlab = new PatternLab();
    $type = new Type();
    $pattern = new Pattern();
    $pattern->state = $state;
    $type->patterns[] = $pattern;
    $patternlab->types[] = $type;
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertEquals($state, $nav['patternTypes'][0]['patternItems'][0]['patternState']);
  }

  protected function makeType($name = null) {
    $type = new Type();
    $type->name = $name;
    return $type;
  }
}