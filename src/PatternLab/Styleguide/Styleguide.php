<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\PatternLab\Styleguide;

use Labcoat\Generator\Files\FileInterface;
use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Patterns\Types\SubtypeInterface;
use Labcoat\PatternLab\Patterns\Types\Type;
use Labcoat\PatternLab\Patterns\Types\TypeInterface;
use Labcoat\PatternLab\Styleguide\Files\Html\Document;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllPage;
use Labcoat\PatternLab\Styleguide\Files\Javascript\AnnotationsFile;
use Labcoat\PatternLab\Styleguide\Files\Assets\AssetFile;
use Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\DataFile;
use Labcoat\PatternLab\Styleguide\Files\Text\LatestChangeFile;
use Labcoat\PatternLab\Styleguide\Files\Html\Patterns\PatternPage;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllSubtypePage;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllTypePage;
use Labcoat\PatternLab\Styleguide\Files\Patterns\EscapedSourceFile;
use Labcoat\PatternLab\Styleguide\Files\Patterns\SourceFile;
use Labcoat\PatternLab\Styleguide\Files\Patterns\TemplateFile;

class Styleguide implements \IteratorAggregate, StyleguideInterface
{
    /**
     * @var array
     */
    protected $annotations = [];

    /**
     * @var string
     */
    protected $assetsDirectory;

    /**
     * @var array
     */
    protected $breakpoints = [];

    /**
     * @var string
     */
    protected $cacheBuster;

    /**
     * @var \Labcoat\Generator\Files\FileInterface[]
     */
    protected $files;

    /**
     * @var array
     */
    protected $hiddenControls = ['hay'];

    /**
     * @var int
     */
    protected $maximumWidth = 2600;

    /**
     * @var int
     */
    protected $minimumWidth = 240;

    /**
     * @var PatternInterface[]
     */
    protected $patterns = [];

    /**
     * @var array
     */
    protected $scripts = [];

    /**
     * @var array
     */
    protected $stylesheets = [];

    /**
     * @var Type[]
     */
    protected $types = [];

    /**
     * @return string
     */
    public function __toString()
    {
        $str = '';
        foreach ($this->getFiles() as $file) {
            $str .= $file->getPath() . "\n";
        }
        return $str;
    }

    /**
     * @param PatternInterface $pattern
     */
    public function addPattern(PatternInterface $pattern)
    {
        $key = $this->getPatternDirectoryName($pattern);
        $this->patterns[$key] = $pattern;
        $this->getOrCreateType($pattern->getType())->addPattern($pattern);
    }

    /**
     * @param string $script
     */
    public function addScript($script)
    {
        $this->scripts[] = $script;
    }

    /**
     * @param string $stylesheet
     */
    public function addStylesheet($stylesheet)
    {
        $this->stylesheets[] = $stylesheet;
    }

    public function getBreakpoints()
    {
        return $this->breakpoints;
    }

    /**
     * @return array
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * @return string
     */
    public function getAssetsDirectory()
    {
        if (!isset($this->assetsDirectory)) $this->assetsDirectory = $this->findAssetsDirectory();
        return $this->assetsDirectory;
    }

    /**
     * @return string
     */
    public function getCacheBuster()
    {
        if (!isset($this->cacheBuster)) $this->cacheBuster = (string)time();
        return $this->cacheBuster;
    }

    /**
     * @return array
     */
    public function getHiddenControls()
    {
        return $this->hiddenControls;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getFiles());
    }

    /**
     * @return int
     */
    public function getMaximumWidth()
    {
        return $this->maximumWidth;
    }

    /**
     * @return int
     */
    public function getMinimumWidth()
    {
        return $this->minimumWidth;
    }

    /**
     * @param PatternInterface $pattern
     * @return string
     */
    public function getPatternDirectoryName(PatternInterface $pattern)
    {
        $segments = [$pattern->getType()];
        if ($pattern->hasSubtype()) $segments[] = $pattern->getSubtype();
        $segments[] = $pattern->getName();
        return $this->makeDirectoryName($segments);
    }

    /**
     * @return array
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * @return array
     */
    public function getStylesheets()
    {
        return $this->stylesheets;
    }

    /**
     * @param TypeInterface $type
     * @return string
     */
    public function getTypeDirectoryName(TypeInterface $type)
    {
        $segments = [$type->getName()];
        if ($type instanceof SubtypeInterface) array_unshift($segments, $type->getType()->getName());
        return $this->makeDirectoryName($segments);
    }

    /**
     * @return Type[]
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param string $body
     * @param array $data
     * @return Document
     */
    public function makeDocument($body, $data = [])
    {
        $document = new Document($this, $body, $data);
        foreach ($this->getStylesheets() as $stylesheet) $document->includeStylesheet($stylesheet);
        foreach ($this->getScripts() as $script) $document->includeScript($script);
        return $document;
    }


    /**
     * @param string $directory
     */
    public function setAssetsDirectory($directory)
    {
        $this->assetsDirectory = $directory;
    }

    /**
     * @param array $breakpoints
     */
    public function setBreakpoints($breakpoints)
    {
        $this->breakpoints = $breakpoints;
    }

    /**
     * @param string $string
     */
    public function setCacheBuster($string)
    {
        $this->cacheBuster = $string;
    }

    /**
     * @param array $hiddenControls
     */
    public function setHiddenControls(array $hiddenControls)
    {
        $this->hiddenControls = $hiddenControls;
    }

    /**
     * @param int $maximumWidth
     */
    public function setMaximumWidth($maximumWidth)
    {
        $this->maximumWidth = $maximumWidth;
    }

    /**
     * @param int $minimumWidth
     */
    public function setMinimumWidth($minimumWidth)
    {
        $this->minimumWidth = $minimumWidth;
    }

    /**
     * @return bool
     */
    public function hasScripts()
    {
        return !empty($this->scripts);
    }

    /**
     * @return bool
     */
    public function hasStylesheets()
    {
        return !empty($this->stylesheets);
    }

    protected function addFile(FileInterface $file)
    {
        $this->files[(string)$file->getPath()] = $file;
    }

    protected function addStyleguidePattern(PatternInterface $pattern)
    {
        $this->patterns[] = $pattern;
        $this->getOrCreateType($pattern->getType())->addPattern($pattern);
    }

    protected function clearFiles()
    {
        $this->files = null;
    }

    protected function findAssetsDirectory()
    {
        if (!$vendor = $this->findVendorDirectory()) return null;
        $path = implode(DIRECTORY_SEPARATOR, [$vendor, 'pattern-lab', 'styleguidekit-assets-default', 'dist']);
        return is_dir($path) ? $path : null;
    }

    protected function findVendorDirectory()
    {
        $className = "Composer\\Autoload\\ClassLoader";
        if (!class_exists($className)) return null;
        $c = new \ReflectionClass($className);
        return dirname($c->getFileName()) . DIRECTORY_SEPARATOR . '..';
    }

    protected function getFiles()
    {
        if (!isset($this->files)) $this->makeFiles();
        return $this->files;
    }

    protected function getOrCreateType($type)
    {
        if (!isset($this->types[$type])) $this->types[$type] = new Type($type);
        return $this->types[$type];
    }

    protected function getPatterns()
    {
        return $this->patterns;
    }

    protected function makeAnnotationsFile()
    {
        $this->addFile(new AnnotationsFile($this->annotations));
    }

    protected function makeAssetFiles()
    {
        if (!$assetsDir = $this->getAssetsDirectory()) return;
        $dir = new \RecursiveDirectoryIterator($assetsDir, \FilesystemIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($files as $file => $obj) {
            $path = substr($file, strlen($assetsDir) + 1);
            $this->addFile(new AssetFile($path, $file));
        }
    }

    protected function makeDataFile()
    {
        $this->addFile(new DataFile($this));
    }

    protected function makeDirectoryName(array $segments)
    {
        return implode('-', $segments);
    }

    protected function makeFiles()
    {
        $this->makePages();
        $this->makeAssetFiles();
        $this->makeDataFile();
        $this->makeAnnotationsFile();
        $this->makeLatestChangeFile();
    }

    protected function makeIndexPages()
    {
        /** @var Files\Html\ViewAll\ViewAllPage[] $indexes */
        $indexes = ['all' => new ViewAllPage($this)];
        foreach ($this->getTypes() as $type) {
            $typeId = $type->getName();
            $indexes[$typeId] = new ViewAllTypePage($this, $type);
            foreach ($type->getSubtypes() as $subtype) {
                $subtypeId = $subtype->getName();
                $indexes[$subtypeId] = new ViewAllSubtypePage($this, $subtype);
                foreach ($subtype->getPatterns() as $pattern) {
                    $indexes['all']->addPattern($pattern);
                    $indexes[$typeId]->addPattern($pattern);
                    $indexes[$subtypeId]->addPattern($pattern);
                }
            }
            foreach ($type->getPatterns() as $pattern) {
                $indexes['all']->addPattern($pattern);
                $indexes[$typeId]->addPattern($pattern);
            }
        }
        foreach ($indexes as $index) $this->addFile($index);
    }

    protected function makeLatestChangeFile()
    {
        $this->addFile(new LatestChangeFile(time()));
    }

    protected function makePages()
    {
        $this->makePatternPages();
        $this->makeIndexPages();
    }

    protected function makePath(array $segments)
    {
        return implode(DIRECTORY_SEPARATOR, $segments);
    }

    protected function makePatternPages()
    {
        foreach ($this->getPatterns() as $pattern) {
            $this->addFile(new PatternPage($this, $pattern));
            $this->addFile(new SourceFile($this, $pattern));
            $this->addFile(new EscapedSourceFile($this, $pattern));
            $this->addFile(new TemplateFile($this, $pattern));
        }
    }
}
