<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Manager;

use Composer\Autoload\ClassMapGenerator;
use DataURI\Data;
use DataURI\Dumper;
use wiejakp\ImageCrop\ImageCrop;
use wiejakp\ImageCrop\Reader\AbstractReader;
use wiejakp\ImageCrop\Reader\BMPReader;
use wiejakp\ImageCrop\Reader\GIFReader;
use wiejakp\ImageCrop\Reader\JPEGReader;
use wiejakp\ImageCrop\Reader\PNGReader;
use wiejakp\ImageCrop\Writer\AbstractWriter;
use wiejakp\ImageCrop\Writer\BMPWriter;
use wiejakp\ImageCrop\Writer\GIFWriter;
use wiejakp\ImageCrop\Writer\JPEGWriter;
use wiejakp\ImageCrop\Writer\PNGWriter;

/**
 * Class AbstractManager
 */
abstract class AbstractManager
{
    /**
     * @var ImageCrop
     */
    protected $core;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var AbstractReader|BMPReader|GIFReader|JPEGReader|PNGReader
     */
    protected $reader;

    /**
     * @var AbstractReader[]
     */
    protected $readers = [];

    /**
     * @var AbstractWriter|BMPWriter|GIFWriter|JPEGWriter|PNGWriter
     */
    protected $writer;

    /**
     * @var AbstractWriter[]
     */
    protected $writers = [];

    /**
     * AbstractManager constructor.
     *
     * @param ImageCrop $core
     */
    public function __construct(ImageCrop $core)
    {
        $this->core = $core;
        $this->namespace = (new \ReflectionClass(ImageCrop::class))->getNamespaceName();
    }

    /**
     * @return ImageCrop
     */
    public function getCore(): ImageCrop
    {
        return $this->core;
    }

    /**
     * @param string|null $class
     *
     * @return string
     */
    public function getTempFile(?string $class = null): string
    {
        if (null === $class) {
            $class = \get_class($this);
        }

        $path = \tempnam(\sys_get_temp_dir(), \sprintf('%s_', $this->getShortName($class)));

        return $path;
    }

    /**
     * @param string $class
     *
     * @return string|null
     */
    public function getShortName(string $class): ?string
    {
        $array = \explode('\\', $class);

        return \array_pop($array);
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    public function getData(string $path): ?string
    {
        $data = \file_get_contents($path);

        return $data ? $data : null;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getDataUri(string $path): string
    {
        $content = $this->getData($path) ?? '';
        $uri = new Data($content, $this->getDataMimeType($path));

        return Dumper::dump($uri);
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    public function getDataMimeType(string $path): ?string
    {
        $mimeType = \mime_content_type($path);

        return $mimeType ? $mimeType : null;
    }

    /**
     * @param string $library
     *
     * @return array
     */
    protected function getManagerLibraries(string $library): array
    {
        $classes = $this->getLibraryClassList($library);
        $objects = $this->getLibraryObjectList($classes);

        return $objects;
    }

    /**
     * @param string $library
     *
     * @return array
     */
    protected function getLibraryClassList(string $library): array
    {
        $libraryPath = $this->getLibraryDirectory($library);
        $libraryClassMap = ClassMapGenerator::createMap($libraryPath);

        // filter out invalid library class maps
        $libraryClassMap = \array_filter($libraryClassMap, function (string $class) use ($library) {
            return $this->isLibraryClass($library, $class);
        }, ARRAY_FILTER_USE_KEY);

        return \array_keys($libraryClassMap);
    }

    /**
     * @param array $classes
     *
     * @return array
     */
    protected function getLibraryObjectList(array $classes): array
    {
        $libraries = [];

        foreach ($classes as $class) {
            $libraries[$class] = new $class($this);
        }

        return $libraries;
    }

    /**
     * @param string $library
     * @param string $class
     *
     * @return bool
     */
    private function isLibraryClass(string $library, string $class): bool
    {
        $namespace = \sprintf('%s\\%s\\', $this->namespace, $library);
        $length = \strlen($namespace);

        $checkPrefix = \substr($class, 0, $length) === $namespace;
        $checkExists = \class_exists($class);
        $checkObject = $checkPrefix && $checkExists && false === (new \ReflectionClass($class))->isAbstract();

        return $checkPrefix && $checkExists && $checkObject;
    }

    /**
     * @param string $library
     *
     * @return string
     */
    private function getLibraryDirectory(string $library): string
    {
        return \sprintf('%s/%s/', $this->getCore()->getRoot(), $library);
    }
}
