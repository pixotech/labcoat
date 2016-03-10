<?php

namespace Labcoat\Variables;

class Parser implements ParserInterface {

  protected $defaultHandler;

  protected $handlers = [];

  protected $variables = [];

  public function __invoke(array $source) {
    return $this->parse($source);
  }

  public function addHandler($prefix, callable $handler) {
    $this->handlers[$prefix] = $handler;
  }

  public function parse(array $source) {
    foreach ($source as $key => $value) {
      if (is_array($value)) {
        $source[$key] = $this->parse($value);
      }
      elseif ($this->isTemplate($value)) {
        try {
          list ($prefix, $name, $selector) = $this->parseTemplate($value);
          $handler = $this->getHandler($prefix);
          $parsed = call_user_func($handler, $name);
          if (is_array($parsed) && !empty($selector)) {
            $variables = new Collection($parsed);
            $parsed = $variables->get($selector);
          }
          $source[$key] = $parsed;
        }
        catch (\Exception $e) {
          trigger_error($e->getMessage());
          $source[$key] = [];
        }
      }
    }
    return $source;
  }

  public function setDefaultHandler(callable $handler) {
    $this->defaultHandler = $handler;
  }

  protected function dataHasVariable($data, $var) {
    if (is_array($data)) {
      return array_key_exists($var, $data);
    }
    return false;
  }

  protected function getDataVariable($data, $var) {
    if (is_array($data)) {
      return $data[$var];
    }
    return null;
  }

  protected function getHandler($prefix) {
    if (empty($prefix)) {
      if (isset($this->defaultHandler)) return $this->defaultHandler;
      throw new \OutOfBoundsException("No default handler available");
    }
    switch ($prefix) {
      case '\\':
        return [$this, 'getTemplateClass'];
      case '$':
        return [$this, 'getTemplateVariable'];
      default:
        if (array_key_exists($prefix, $this->handlers)) return $this->handlers[$prefix];
    }
    throw new \OutOfBoundsException("Unknown prefix: $prefix");
  }

  protected function getTemplateClass($className) {
    if (!class_exists($className)) throw new \OutOfBoundsException("Unknown class: $className");
    $klass = new \ReflectionClass($className);
    return $klass->newInstance();
  }

  protected function getTemplateRegex() {
    return '/^{{\s*(\W?)([^\s#]*)#?(\S*)\s*}}$/';
  }

  protected function getTemplateVariable($name) {
    if (!array_key_exists($name, $this->variables)) throw new \OutOfBoundsException("Unknown variable: $name");
    return $this->variables[$name];
  }

  protected function isTemplate($value) {
    return is_string($value) && preg_match($this->getTemplateRegex(), trim($value));
  }

  protected function parseTemplate($template) {
    preg_match($this->getTemplateRegex(), trim($template), $m);
    list ($match, $prefix, $name, $vars) = $m;
    return [$prefix, $name, $vars];
  }
}