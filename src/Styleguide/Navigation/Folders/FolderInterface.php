<?php

namespace Labcoat\Styleguide\Navigation\Folders;

interface FolderInterface {

  /**
   * @return \Labcoat\Styleguide\Navigation\ItemInterface[]
   */
  public function getItems();

  /**
   * @return string
   */
  public function getLowercaseName();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return \Labcoat\Styleguide\Navigation\TypeItemInterface[]
   */
  public function getTypeItems();

  /**
   * @return string
   */
  public function getUppercaseName();

  /**
   * @return bool
   */
  public function hasTypeItems();
}