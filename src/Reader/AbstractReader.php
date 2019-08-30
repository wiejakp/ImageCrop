<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Reader;

use wiejakp\ImageCrop\Manager\ReaderManager;

/**
 * Class AbstractReader
 *
 * @package wiejakp\ImageCrop\Reader
 */
abstract class AbstractReader
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var ReaderManager
     */
    protected $manager;

    /**
     * @var string|null
     */
    protected $source;

    /**
     * @var string|null
     */
    protected $destination;

    /**
     * @var false|resource
     */
    protected $resource;

    /**
     * AbstractReader constructor.
     *
     * @param ReaderManager $manager
     */
    public function __construct(ReaderManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return self
     */
    protected function setClass(string $class): self
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return ReaderManager
     */
    public function getManager(): ReaderManager
    {
        return $this->manager;
    }

    /**
     * @param ReaderManager $manager
     *
     * @return self
     */
    public function setManager(ReaderManager $manager): self
    {
        $this->manager = $manager;
        return $this;
    }

    /**
     * @return resource|false
     * @throws \Exception
     */
    public function getResource()
    {
        if (null === $this->resource) {
            throw new \Exception('Resource was never set.');
        }

        return $this->resource ?? false;
    }

    /**
     * @param resource $resource
     *
     * @return self
     */
    public function setResource($resource): self
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @param string $path
     *
     * @return self
     */
    public function loadFromPath(string $path)
    {
        \trigger_error('Do Not Call Directly');
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getManager()->getShortName($this->getClass());
    }
}
