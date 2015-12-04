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

  public function testNavItemSubtypeName() {
    $name = 'subtype';
    $patternlab = new PatternLab();
    $type = new Type();
    $subtype = new Subtype();
    $subtype->name = $name;
    $type->subtypes[] = $subtype;
    $patternlab->types[] = $type;
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertEquals($name, $nav['patternTypes'][0]['patternTypeItems'][0]['patternSubtype']);
  }

  public function testNavItemSubtypeLowercaseName() {
    $name = 'subtype';
    $patternlab = new PatternLab();
    $type = new Type();
    $subtype = new Subtype();
    $subtype->name = $name;
    $type->subtypes[] = $subtype;
    $patternlab->types[] = $type;
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertEquals($name, $nav['patternTypes'][0]['patternTypeItems'][0]['patternSubtypeLC']);
  }

  public function testNavItemSubtypeUppercaseName() {
    $label = 'Subtype Label';
    $patternlab = new PatternLab();
    $type = new Type();
    $subtype = new Subtype();
    $subtype->label = $label;
    $type->subtypes[] = $subtype;
    $patternlab->types[] = $type;
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertEquals($label, $nav['patternTypes'][0]['patternTypeItems'][0]['patternSubtypeUC']);
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

  public function testNavItemPatternName() {
    $name = 'Pattern Name';
    $patternlab = new PatternLab();
    $type = new Type();
    $pattern = new Pattern();
    $pattern->label = $name;
    $type->patterns[] = $pattern;
    $patternlab->types[] = $type;
    $file = new DataFile($patternlab);
    $nav = $file->getNavItems();
    $this->assertEquals($name, $nav['patternTypes'][0]['patternItems'][0]['patternName']);
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