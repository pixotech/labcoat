<?php

namespace Labcoat\PatternLab\Styleguide\Kit\Partials;

class PatternSectionSubtype {

  public function __toString() {
    return <<<PATTERNSECTIONSUBTYPE

<div id="{{ partial.patternPartial }}" class="sg-subtype">
	<h2><a href="../../patterns/{{ partial.patternLink }}" class="patternLink" data-patternpartial="{{ partial.patternPartial }}">{{ partial.patternName }}</a></h2>
	<div class="sg-pattern-body">
		{{ partial.patternDesc | raw }}
	</div>
</div>

PATTERNSECTIONSUBTYPE;
  }
}