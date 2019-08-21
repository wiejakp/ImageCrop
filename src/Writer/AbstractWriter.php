<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Writer;

use wiejakp\ImageCrop\Manager\WriterManager;
use wiejakp\ImageCrop\Reader\AbstractReader;

/**
 * Class AbstractWriter
 *
 * @package wiejakp\ImageCrop\Writer
 */
abstract class AbstractWriter
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var WriterManager
     */
    protected $manager;

    /**
     * @var AbstractReader
     */
    protected $reader;

    /**
     * @var string
     */
    protected $path;

    /**
     * AbstractWriter constructor.
     *
     * @param WriterManager $manager
     */
    public function __construct(WriterManager $manager)
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
     * @return self
     */
    protected function setClass(string $class): self
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return WriterManager
     */
    public function getManager(): WriterManager
    {
        return $this->manager;
    }

    /**
     * @param WriterManager $manager
     * @return self
     */
    public function setManager(WriterManager $manager): self
    {
        $this->manager = $manager;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        if (empty($this->path)) {
            $this->path = $this->manager->getTempFile($this->getClass());
        }

        return $this->path;
    }

    /**
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string|null
     */
    public function write(): ?string
    {
        \trigger_error('Do Not Call Directly');
        return null;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return \file_get_contents($this->getPath());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getManager()->getShortName($this->getClass());
    }
}
