<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Manager;

use wiejakp\ImageCrop\ImageCrop;

/**
 * Class AbstractManager
 *
 * @package wiejakp\ImageCrop\Manager
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
     * @param string $library
     * @param string $class
     * @return bool
     */
    protected function isLibraryClass(string $library, string $class): bool
    {
        $namespace = \sprintf('%s\\%s\\', $this->namespace, $library);
        $length = \strlen($namespace);

        return \substr($class, 0, $length) === $namespace && \class_exists($class);
    }

    /**
     * @param string|null $class
     * @return string
     */
    public function getTempFile(?string $class = null): string
    {
        return \tempnam(\sys_get_temp_dir(), \sprintf('%s_', $this->getShortName($class)));
    }

    /**
     * @param string $class
     * @return string
     */
    public function getShortName(string $class): string
    {
        return \array_pop(\explode('\\', $class));
    }
}
