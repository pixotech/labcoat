<?php

namespace Labcoat\Templates;

class Template implements TemplateInterface {

  protected static $extension = 'twig';

  protected $id;

  protected $includedTemplates;

  protected $file;

  protected $valid;

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

  protected static function getFileRegex() {
    return '|\.' . preg_quote(static::$extension) . '$|';
  }

  protected static function getFilesIterator($dir) {
    return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
  }

  protected static function getIdFromPath($path, $dir) {
    return str_replace(DIRECTORY_SEPARATOR, '/', static::getRelativePathWithoutExtension($path, $dir));
  }

  protected static function getRelativePathWithoutExtension($path, $dir) {
    return substr($path, strlen($dir) + 1, -1 - strlen(static::$extension));
  }

  protected static function isIncludeToken(\Twig_Token $token) {
    return self::isNameToken($token) && in_array($token->getValue(), ['include', 'extend']);
  }

  protected static function isNameToken(\Twig_Token $token) {
    return $token->getType() == \Twig_Token::NAME_TYPE;
  }

  protected static function makeCollection() {
    return new Collection();
  }

  protected static function makeDirectoryIterator($dir) {
    return new \RegexIterator(static::getFilesIterator($dir), static::getFileRegex(), \RegexIterator::MATCH);
  }

  public function __construct(\SplFileInfo $file, $id = null) {
    $this->file = $file;
    if (isset($id)) $this->id;
  }

  public function __invoke(\Twig_Environment $parser, array $vars = []) {
    return $parser->render($this->getId(), $vars);
  }

  public function __toString() {
    return $this->getId();
  }

  public function getFile() {
    return $this->file;
  }

  public function getId() {
    return $this->id;
  }

  public function getIncludedTemplates() {
    if (!isset($this->includedTemplates)) $this->parseTemplate();
    return $this->includedTemplates;
  }

  public function getTime() {
    $time = new \DateTime();
    $time->setTimestamp($this->getTimestamp());
    return $time;
  }

  /**
   * @param string $name
   * @return bool
   */
  public function is($name) {
    return $name == $this->getId();
  }

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

  protected function parseTemplate() {
    $this->valid = true;
    $templates = [];
    try {
      $tokens = $this->getTokens();
      while (!$tokens->isEOF()) {
        $token = $tokens->next();
        if ($this->isIncludeToken($token)) {
          $next = $tokens->next()->getValue();
          if ($next == '(') $next = $tokens->next()->getValue();
          $templates[] = $next;
        }
      }
      $this->includedTemplates = array_unique($templates);
    }
    catch (\Twig_Error_Syntax $e) {
      $this->valid = false;
    }
  }
}