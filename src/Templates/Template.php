<?php

namespace Labcoat\Templates;

class Template implements TemplateInterface {

  /**
   * @var string
   */
  protected static $extension = 'twig';

  /**
   * @var string
   */
  protected $id;

  /**
   * @var array
   */
  protected $includedTemplates;

  /**
   * @var \SplFileInfo
   */
  protected $file;

  /**
   * @var string
   */
  protected $parentTemplate;

  /**
   * @var bool
   */
  protected $valid;

  /**
   * @param string $dir
   * @return Collection
   */
  public static function inDirectory($dir) {
    $collection = static::makeCollection();
    foreach (static::makeDirectoryIterator($dir) as $path => $file) {
      try {
        $collection->add(new static($file, static::getIdFromPath($path, $dir)));
      }
      catch (\InvalidArgumentException $e) {
        continue;
      }
    }
    return $collection;
  }

  /**
   * @return string
   */
  protected static function getFileRegex() {
    return '|\.' . preg_quote(static::$extension) . '$|';
  }

  /**
   * @param string $dir
   * @return \RecursiveIteratorIterator
   */
  protected static function getFilesIterator($dir) {
    return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
  }

  /**
   * @param string $path
   * @param string $dir
   * @return string
   */
  protected static function getIdFromPath($path, $dir) {
    return str_replace(DIRECTORY_SEPARATOR, '/', static::getRelativePathWithoutExtension($path, $dir));
  }

  /**
   * @param string $path
   * @param string $dir
   * @return string
   */
  protected static function getRelativePathWithoutExtension($path, $dir) {
    return substr($path, strlen($dir) + 1, -1 - strlen(static::$extension));
  }

  /**
   * @param \Twig_Token $token
   * @return bool
   */
  protected static function isIncludeToken(\Twig_Token $token) {
    return self::isNameToken($token) && in_array($token->getValue(), ['include', 'extend']);
  }

  /**
   * @param \Twig_Token $token
   * @return bool
   */
  protected static function isNameToken(\Twig_Token $token) {
    return $token->getType() == \Twig_Token::NAME_TYPE;
  }

  /**
   * @return Collection
   */
  protected static function makeCollection() {
    return new Collection();
  }

  /**
   * @param string $dir
   * @return \RegexIterator
   */
  protected static function makeDirectoryIterator($dir) {
    return new \RegexIterator(static::getFilesIterator($dir), static::getFileRegex(), \RegexIterator::MATCH);
  }

  /**
   * @param \SplFileInfo $file
   * @param string $id
   */
  public function __construct(\SplFileInfo $file, $id = null) {
    $this->file = $file;
    if (isset($id)) $this->id;
  }

  /**
   * @param \Twig_Environment $parser
   * @param array $vars
   * @return string
   */
  public function __invoke(\Twig_Environment $parser, array $vars = []) {
    return $parser->render($this->getId(), $vars);
  }

  /**
   * @return string
   */
  public function __toString() {
    return $this->getId();
  }

  /**
   * @return array
   */
  public function getDependencies() {
    $dependencies = $this->getIncludedTemplates();
    if ($this->hasParent()) array_unshift($dependencies, $this->getParent());
    return $dependencies;
  }

  /**
   * @return \SplFileInfo
   */
  public function getFile() {
    return $this->file;
  }

  /**
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return array
   */
  public function getIncludedTemplates() {
    if (!isset($this->includedTemplates)) $this->parseTemplate();
    return $this->includedTemplates;
  }

  /**
   * @return string
   * @throws \BadMethodCallException
   */
  public function getParent() {
    if (!isset($this->parentTemplate)) $this->parseTemplate();
    if (!$this->hasParent()) throw new \BadMethodCallException("No template parent");
    return $this->parentTemplate;
  }

  /**
   * @return \DateTime
   */
  public function getTime() {
    $time = new \DateTime();
    $time->setTimestamp($this->getTimestamp());
    return $time;
  }

  /**
   * @return bool
   */
  public function hasParent() {
    if (!isset($this->parentTemplate)) $this->parseTemplate();
    return !empty($this->parentTemplate);
  }

  /**
   * @param string $name
   * @return bool
   */
  public function is($name) {
    return $name == $this->getId();
  }

  /**
   * @return bool
   */
  public function isValid() {
    if (!isset($this->valid)) $this->parseTemplate();
    return $this->valid;
  }

  /**
   * @return string
   */
  protected function getContent() {
    return file_get_contents($this->getFile());
  }

  /**
   * @return \Twig_Lexer
   */
  protected function getLexer() {
    return new \Twig_Lexer(new \Twig_Environment());
  }

  /**
   * @return int
   */
  protected function getTimestamp() {
    return $this->getFile()->getMTime();
  }

  /**
   * @return \Twig_TokenStream
   * @throws \Twig_Error_Syntax
   */
  protected function getTokens() {
    return $this->getLexer()->tokenize($this->getContent());
  }

  /**
   * Validate the template and find dependencies
   */
  protected function parseTemplate() {
    $this->parentTemplate = false;
    $this->includedTemplates = [];
    $this->valid = true;
    try {
      $tokens = $this->getTokens();
      while (!$tokens->isEOF()) {
        $token = $tokens->next();
        if ($this->isIncludeToken($token)) {
          $next = $tokens->next()->getValue();
          if ($next == '(') $next = $tokens->next()->getValue();
          if ($token->getValue() == 'extends') $this->parentTemplate = $next;
          else $this->includedTemplates[] = $next;
        }
      }
      $this->includedTemplates = array_unique($this->includedTemplates);
    }
    catch (\Twig_Error_Syntax $e) {
      $this->valid = false;
    }
  }
}