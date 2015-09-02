<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\Pages\PageInterface;
use Labcoat\Styleguide\StyleguideInterface;

class PageFile extends File {

  /**
   * @var PageInterface
   */
  protected $page;

  public function __construct(PageInterface $page) {
    $this->page = $page;
  }

  public function put(StyleguideInterface $styleguide, $path) {
    $contents = $this->page->render($styleguide);
    file_put_contents($path, $contents);
  }

  public function getPath() {
    $path = $this->page->getPath();
    return is_array($path) ? $this->makePath($path) : $path;
  }

  public function getTime() {
    return $this->page->getTime();
  }
}