<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Manager;

use DataURI\Data;
use DataURI\Dumper;
use wiejakp\ImageCrop\ImageCrop;

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
     *
     * @throws \Exception
     */
    public function getTempFile(?string $class = null): string
    {
        if (null === $class) {
            $class = \get_class($this);
        }

        $path = \tempnam(\sys_get_temp_dir(), \sprintf('%s_', $this->getShortName($class)));

        if (false === $path) {
            throw new \Exception('Unable to fetch a temporary file.');
        }

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
     * @param string $class
     *
     * @return bool
     */
    protected function isLibraryClass(string $library, string $class): bool
    {
        $namespace = \sprintf('%s\\%s\\', $this->namespace, $library);
        $length = \strlen($namespace);

        return \substr($class, 0, $length) === $namespace && \class_exists($class);
    }
}
