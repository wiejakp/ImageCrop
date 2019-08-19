<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop;

use wiejakp\ImageCrop\Manager\ReaderManager;
use wiejakp\ImageCrop\Manager\WriterManager;
use wiejakp\ImageCrop\Reader\AbstractReader;
use wiejakp\ImageCrop\Writer\AbstractWriter;

/**
 * Class ImageCrop
 *
 * @package wiejakp\ImageCrop
 */
class ImageCrop
{
    /**
     * @var ReaderManager
     */
    private $readerManager;

    /**
     * @var WriterManager
     */
    private $writerManager;

    /**
     * @var bool
     */
    private $empty = false;

    /**
     * ImageCrop constructor.
     */
    public function __construct()
    {
        $this->readerManager = new ReaderManager();
        $this->writerManager = new WriterManager();
    }

    /**
     * @param string $class
     * @return AbstractReader
     */
    public function getReader(string $class): AbstractReader
    {
        return $this->readerManager->getReader($class);
    }

    /**
     * @param string $class
     * @return AbstractWriter
     */
    public function getWriter(string $class): AbstractWriter
    {
        return $this->writerManager->getWriter($class);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->empty;
    }

    /**
     * @param AbstractReader $reader
     * @return self
     */
    public function cropTop(AbstractReader $reader): self
    {
        $original = $reader->getResource();

        // image parameters
        $top = 0;

        for (; $top < \imagesy($original); ++$top) {
            for ($x = 0; $x < \imagesx($original); ++$x) {
                if (\imagecolorat($original, $x, $top) != 0xFFFFFF) {
                    break 2;
                }
            }
        }

        $newWidth = \imagesx($original);
        $newHeight = \imagesy($original) - $top;

        if (0 === $newWidth || 0 === $newHeight) {
            $this->empty = true;
        }

        $modified = \imagecrop(
            $original,
            ['x' => 0, 'y' => $top, 'width' => $newWidth, 'height' => $newHeight]
        );

        if ($modified) {
            $reader->setResource($modified);
        }

        return $this;
    }

    /**
     * @param AbstractReader $reader
     * @return self
     */
    public function cropRight(AbstractReader $reader): self
    {
        $original = $reader->getResource();

        // image parameters
        $right = 0;

        for (; $right < \imagesx($original); ++$right) {
            for ($x = 0; $x < \imagesy($original); ++$x) {
                if (\imagecolorat($original, \imagesx($original) - $right - 1, $x) != 0xFFFFFF) {
                    break 2;
                }
            }
        }

        $newWidth = \imagesx($original) - $right;
        $newHeight = \imagesy($original);

        if (0 === $newWidth || 0 === $newHeight) {
            $this->empty = true;
        }

        $modified = \imagecrop(
            $original,
            ['x' => 0, 'y' => 0, 'width' => $newWidth, 'height' => $newHeight]
        );

        if ($modified) {
            $reader->setResource($modified);
        }

        return $this;
    }

    /**
     * @param AbstractReader $reader
     * @return self
     */
    public function cropBottom(AbstractReader $reader): self
    {
        $original = $reader->getResource();

        // image parameters
        $bottom = 0;

        for (; $bottom < \imagesy($original); ++$bottom) {
            for ($x = 0; $x < \imagesx($original); ++$x) {
                if (\imagecolorat($original, $x, \imagesy($original) - $bottom - 1) != 0xFFFFFF) {
                    break 2;
                }
            }
        }

        $newWidth = \imagesx($original);
        $newHeight = \imagesy($original) - $bottom;

        if (0 === $newWidth || 0 === $newHeight) {
            $this->empty = true;
        }

        $modified = \imagecrop(
            $original,
            ['x' => 0, 'y' => 0, 'width' => $newWidth, 'height' => $newHeight]
        );

        if ($modified) {
            $reader->setResource($modified);
        }

        return $this;
    }

    /**
     * @param AbstractReader $reader
     * @return self
     */
    public function cropLeft(AbstractReader $reader): self
    {
        $original = $reader->getResource();

        // image parameters
        $left = 0;

        for (; $left < \imagesx($original); ++$left) {
            for ($y = 0; $y < \imagesy($original); ++$y) {
                if (\imagecolorat($original, $left, $y) != 0xFFFFFF) {
                    break 2;
                }
            }
        }

        $newWidth = \imagesx($original) - $left;
        $newHeight = \imagesy($original);

        if (0 === $newWidth || 0 === $newHeight) {
            $this->empty = true;
        }

        $modified = \imagecrop(
            $original,
            ['x' => $left, 'y' => 0, 'width' => $newWidth, 'height' => $newHeight]
        );

        if ($modified) {
            $reader->setResource($modified);
        }

        return $this;
    }
}