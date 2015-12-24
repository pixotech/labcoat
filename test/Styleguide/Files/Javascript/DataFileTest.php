<?php

namespace Labcoat\Styleguide\Files\Javascript;

use Labcoat\Mocks\PatternLab;
use Labcoat\Mocks\PatternLab\Patterns\Pattern;
use Labcoat\Mocks\PatternLab\Patterns\Types\Subtype;
use Labcoat\Mocks\PatternLab\Patterns\Types\Type;
use Labcoat\Mocks\Styleguide\Styleguide;

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

  public function testNavItemPatternPagePath() {
    $path = 'path-to-the-pattern';
    $pattern = new Pattern();
    $pattern->pagePath = $path;
    $nav = DataFile::makeNavPattern($pattern);
    $this->assertEquals($path, $nav['patternPath']);
  }

  public function testNavItemPatternPartial() {
    $partial = 'path-to-the-pattern';
    $pattern = new Pattern();
    $pattern->partial = $partial;
    $nav = DataFile::makeNavPattern($pattern);
    $this->assertEquals($partial, $nav['patternPartial']);
  }

  public function testNavItemPatternState() {
    $state = 'state';
    $pattern = new Pattern();
    $pattern->state = $state;
    $nav = DataFile::makeNavPattern($pattern);
    $this->assertEquals($state, $nav['patternState']);
  }




  public function testNavItems() {
    $styleguide = new Styleguide();
    $patternlab = new PatternLab();
    $file = new DataFile($styleguide, $patternlab);
    $nav = $file->getNavItems();
    $this->assertCount(1, $nav);
    $this->assertArrayHasKey('patternTypes', $nav);
    $this->assertTrue(is_array($nav['patternTypes']));
  }

  public function testNavItemTypes() {
    $styleguide = new Styleguide();
    $patternlab = new PatternLab();
    $patternlab->types[] = new Type();
    $file = new DataFile($styleguide, $patternlab);
    $nav = $file->getNavItems();
    $this->assertCount(1, $nav['patternTypes']);
  }

  public function testNavItemSubtypes() {
    $styleguide = new Styleguide();
    $patternlab = new PatternLab();
    $type = new Type();
    $subtype = new Subtype();
    $type->subtypes[] = $subtype;
    $patternlab->types[] = $type;
    $file = new DataFile($styleguide, $patternlab);
    $nav = $file->getNavItems();
    $this->assertCount(1, $nav['patternTypes'][0]['patternTypeItems']);
  }

  public function testNavItemTypePatterns() {
    $styleguide = new Styleguide();
    $patternlab = new PatternLab();
    $type = new Type();
    $pattern = new Pattern();
    $type->patterns[] = $pattern;
    $patternlab->types[] = $type;
    $file = new DataFile($styleguide, $patternlab);
    $nav = $file->getNavItems();
    $this->assertCount(1, $nav['patternTypes'][0]['patternItems']);
  }

  public function testNavItemTypePatternsIncludeSubtypeIndexes() {
    $styleguide = new Styleguide();
    $patternlab = new PatternLab();
    $type = new Type();
    $subtype = new Subtype();
    $type->subtypes[] = $subtype;
    $pattern = new Pattern();
    $type->patterns[] = $pattern;
    $patternlab->types[] = $type;
    $file = new DataFile($styleguide, $patternlab);
    $nav = $file->getNavItems();
    $this->assertCount(2, $nav['patternTypes'][0]['patternItems']);
  }
}