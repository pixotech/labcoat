<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

class ViewAllSubtypePage extends ViewAllTypePage implements ViewAllSubtypePageInterface {

  public function getPartial() {
    return 'viewall-' . $this->type->getPartial();
  }
}
