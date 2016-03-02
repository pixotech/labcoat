<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat;

use Labcoat\Configuration\ConfigurationInterface;
use Labcoat\Configuration\LabcoatConfiguration;
use Labcoat\Configuration\StandardEditionConfiguration;
use Labcoat\PatternLab\Patterns\Pattern;
use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Styleguide;
use Labcoat\PatternLab\Templates\TemplateInterface;

/**
 * @deprecated 1.1.0 PatternLab classes moved to \Labcoat\PatternLab
 */
class PatternLab implements PatternLabInterface {

  /**
   * @var ConfigurationInterface
   */
  protected $config;

  /**
   * @var array
   */
  protected $globalData;

  /**
   * @var PatternLab\Templates\CollectionInterface
   */
  protected $templates;

  /**
   * @var \Twig_Environment
   */
  protected $twig;

  /**
   * Is this a partial name?
   *
   * Labcoat assumes that a name is a partial if it doesn't contain a slash
   *
   * @param string $name The name of the pattern
   * @return bool True if the name is a path; otherwise, false
   */
  public static function isPartialName($name) {
    return false === strpos($name, '/');
  }

  /**
   * Is this a path?
   *
   * Labcoat assumes that a name is a path if it contains a slash
   *
   * @param string $name The name of the pattern
   * @return bool True if the name is a path; otherwise, false
   */
  public static function isPathName($name) {
    return false !== strpos($name, DIRECTORY_SEPARATOR);
  }

  /**
   * Load a Pattern Lab installation that uses the default Labcoat file structure
   *
   * @param string $dir The path to the Pattern Lab installation
   * @return PatternLab A new PatternLab object
   */
  public static function load($dir) {
    $config = new LabcoatConfiguration($dir);
    return new PatternLab($config);
  }

  /**
   * Load a Pattern Lab installation that uses the Standard Edition file structure
   *
   * @param string $dir The path to the Pattern Lab installation
   * @return PatternLab A new PatternLab object
   */
  public static function loadStandardEdition($dir) {
    $config = new StandardEditionConfiguration($dir);
    return new PatternLab($config);
  }

  /**
   * Make a path string from an array of segments
   *
   * @param array $segments An array of path segments
   * @return string A path
   */
  public static function makePath(array $segments) {
    return implode('/', $segments);
  }

  /**
   * Constructor
   *
   * @param \Labcoat\Configuration\ConfigurationInterface $config A configuration object
   */
  public function __construct(ConfigurationInterface $config) {
    $this->config = $config;
  }

  /**
   * @return \Labcoat\PatternLab\Patterns\PatternInterface[]
   */
  public function getPatterns() {
    return $this->patterns;
  }

  /**
   * @return PatternLab\Styleguide\StyleguideInterface
   */
  public function getStyleguide() {
    $styleguide = new Styleguide();
    $styleguide->setAnnotationsFilePath($this->config->getAnnotationsFile());
    $styleguide->setPatternHeaderTemplatePath($this->config->getStyleguideHeader());
    $styleguide->setPatternFooterTemplatePath($this->config->getStyleguideFooter());
    foreach ($this->getTemplates() as $template) {
      /** @var PatternLab\Templates\Template $template */
      $pattern = $this->makePattern($template);
      $styleguide->addPattern($pattern);
      foreach ($template->getVariants() as $variant => $data) {
        $styleguide->addPattern($this->makePseudoPattern($pattern, $variant, $data));
      }
    }
    return $styleguide;
  }

  protected function getGlobalData() {
    if (!isset($this->globalData)) {
      $this->globalData = [];
      foreach ($this->config->getGlobalDataFiles() as $file) {
        $fileData = json_decode(file_get_contents($file), true);
        $this->globalData = array_replace_recursive($this->globalData, $fileData);
      }
    }
    return $this->globalData;
  }

  protected function getTemplates() {
    if (!isset($this->templates)) {
      $this->templates = $this->config->getTemplates();
    }
    return $this->templates;
  }

  protected function getTwig() {
    if (!isset($this->twig)) {
      $this->twig = new \Twig_Environment($this->getTemplates());
    }
    return $this->twig;
  }

  protected function makePattern(TemplateInterface $template) {
    list($name, $type, $subtype) = PatternLab\PatternLab::splitPath($template->getId());
    $pattern = new Pattern($name, $type, $subtype);
    $pattern->setLabel(PatternLab\PatternLab::makeLabel($name));
    $pattern->setTemplateContent(file_get_contents($template->getFile()));
    $pattern->setExample($this->makePatternExample($template));
    return $pattern;
  }

  protected function makePatternExample(TemplateInterface $template) {
    $templateData = $template->hasData() ? $template->getData() : [];
    $data = array_replace_recursive($this->getGlobalData(), $templateData);
    return $this->getTwig()->render($template->getId(), $data);
  }

  protected function makePseudoPattern(PatternInterface $pattern, $variant, $data) {
    $name = $pattern->getName() . '-' . $variant;
    $pseudo = new Pattern($name, $pattern->getType(), $pattern->hasSubtype() ? $pattern->getSubtype() : null);
    $pseudo->setLabel(PatternLab\PatternLab::makeLabel($name));
    $pseudo->setTemplateContent($pattern->getTemplateContent());
    return $pseudo;
  }
}
