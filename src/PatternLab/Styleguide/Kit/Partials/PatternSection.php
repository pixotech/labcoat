<?php

namespace Labcoat\PatternLab\Styleguide\Kit\Partials;

use Labcoat\Html\Element;
use Labcoat\PatternLab\Patterns\PatternInterface;

class PatternSection {

  protected $pattern;

  public function __construct(PatternInterface $source) {
    $this->pattern = $source;
  }

  public function __toString() {
    return (string) $this->getElement();
  }

  public function getElement() {
    return new Element('div', $this->getElementAttributes(), $this->getElementContent());
  }

  public function getElementAttributes() {
    return [
      'id' => $this->getPatternPartial(),
      'class' => 'sg-pattern'
    ];
  }

  public function getElementContent() {
    $content  = $this->getPatternHead();
    $content .= $this->getPatternDescription();
    $content .= $this->getPatternExample();
    $content .= $this->getPatternExtra();
    return $content;
  }

  /**
   * @return PatternInterface
   */
  public function getPattern() {
    return $this->pattern;
  }

  public function getPatternAnnotations() {
    return <<<PATTERNANNOTATIONS
		<div class="sg-pattern-extra-annotations" style="display: none">
			<span class="sg-pattern-extra-name">Annotations</span>
			<div id="sg-pattern-extra-annotations-container">
			</div>
		</div>
PATTERNANNOTATIONS;
  }

  /**
   * @return Element
   */
  public function getPatternDescription() {
    $description = $this->getPattern()->getDescription();
    return new Element('div', ['class' => 'sg-pattern-desc'], new Element('p', [], $description));
  }

  /**
   * @return Element
   */
  public function getPatternExample() {
    $example = $this->getPattern()->getExample();
    return new Element('div', ['class' => 'sg-pattern-example'], $example);
  }

  public function getPatternExtra() {
    return <<<PATTERNEXTRA
	<div class="sg-pattern-extra">
	  {$this->getPatternAnnotations()}
		<div class="sg-pattern-extra-html" style="display: none">
			<span class="sg-pattern-extra-name">HTML</span>
			<pre>
				<code id="sg-pattern-extra-html-container"></code>
			</pre>
		</div>
		<div class="sg-pattern-extra-engine" style="display: none">
			<span class="sg-pattern-extra-name">Twig</span>
			<pre>
				<code id="sg-pattern-extra-engine-container"></code>
			</pre>
		</div>
		{$this->getPatternLineages()}
	</div>
PATTERNEXTRA;

  }

  public function getPatternHead() {
    return <<<PATTERHEAD
	<div class="sg-pattern-head">
		<h3>{$this->getPatternLink()}</h3>
		<div class="sg-pattern-head-actions">
			<!--Pattern header options-->
		</div>
	</div>
PATTERHEAD;
  }

  public function getPatternLineage() {
    return <<<PATTERNLINEAGE
				<div class="sg-pattern-extra-lineage">
					The <span class="sg-pattern-extra-lineage-name">{{ partial.patternPartial }}</span> pattern contains the following pattern(s):
					<ul>
					{% for patternLineage in partial.patternLineages %}
						<li> <a href="{{ patternLineage.lineagePath }}" class="{% if patternLineage.lineageState %}sg-pattern-state {{ patternLineage.lineageState }} {% endif %}" data-patternpartial="{{ patternLineage.lineagePattern }}">{{ patternLineage.lineagePattern }}</a></li>
					{% endfor %}
					</ul>
				</div>
PATTERNLINEAGE;
  }

  public function getPatternLineages() {
    return new Element('div', $this->getPatternLineagesAttributes(), $this->getPatternLineagesContent());
  }

  public function getPatternLineagesAttributes() {
    return [
      'class' => 'sg-pattern-extra-lineage',
      'style' => 'display: none',
    ];
  }

  public function getPatternLineagesContent() {
    $content = '';
    if ($this->hasPatternLineage()) $content .= $this->getPatternLineage();
    if ($this->hasPatternReverseLineage()) $content .= $this->getPatternReverseLineage();
    if (!$this->hasPatternExtraLineage()) $content .= $this->getPatternNoExtraLineageMessage();
    return $content;
  }

  public function getPatternLink() {
    $attributes = [
      'href' => $this->getPatternUrl(),
      'class' => 'patternLink',
      'data-patternpartial' => $this->getPatternPartial(),
    ];
    return new Element('a', $attributes);
  }

  public function getPatternNoExtraLineageMessage() {
    $partial = $this->getPatternPartial();
    $span = new Element('span', ['class' => 'sg-pattern-extra-lineage-name'], $partial);
    return "The {$span} pattern doesn't have any lineage information.";
  }

  public function getPatternPartial() {
    return $this->getPattern()->getPartial();
  }

  public function getPatternReverseLineage() {
    return <<<PATTERNREVERSELINEAGE
				<div class="sg-pattern-extra-lineage">
					The <span class="sg-pattern-extra-lineage-name">{{ partial.patternPartial }}</span> pattern is included in the following pattern(s):
					<ul>
					{% for patternLineageR in partial.patternLineagesR %}
						<li> <a href="{{ patternLineageR.lineagePath }}" class="{% if patternLineageR.lineageState %}sg-pattern-state {{ patternLineageR.lineageState }} {% endif %}" data-patternpartial="{{ patternLineageR.lineagePattern }}">{{ patternLineageR.lineagePattern }}</a></li>
					{% endfor %}
					</ul>
				</div>
PATTERNREVERSELINEAGE;
  }

  public function getPatternUrl() {
    return "../../patterns/{{ partial.patternLink }}";
  }

  public function hasPatternExtraLineage() {
    return false;
  }

  public function hasPatternLineage() {
    return false;
  }

  public function hasPatternReverseLineage() {
    return false;
  }
}