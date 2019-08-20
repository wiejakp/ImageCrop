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
use wiejakp\ImageCrop\Reader\JPEGReader;
use wiejakp\ImageCrop\Writer\AbstractWriter;
use wiejakp\ImageCrop\Writer\BMPWriter;
use wiejakp\ImageCrop\Writer\GIFWriter;
use wiejakp\ImageCrop\Writer\JPEGWriter;
use wiejakp\ImageCrop\Writer\PNGWriter;

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
     * @var AbstractReader|JPEGReader|null
     */
    private $reader;

    /**
     * @var AbstractWriter|BMPWriter|GIFWriter|JPEGWriter|PNGWriter|null
     */
    private $writer;

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
     * @return AbstractReader|JPEGReader|null
     */
    public function getReader(): ?AbstractReader
    {
        return $this->reader;
    }

    /**
     * @param string|JPEGReader $reader
     * @return self
     * @throws \Exception
     */
    public function setReader($reader): self
    {
        switch (true) {
            case \is_string($reader):
                $this->reader = $this->readerManager->getReader($reader);
                break;

            case \is_subclass_of($reader, AbstractReader::class):
                $this->reader = $reader;
                break;

            default:
                throw new \Exception('Suggested Reader is not supported.');
        }

        return $this;
    }

    /**
     * @return AbstractWriter|BMPWriter|GIFWriter|JPEGWriter|PNGWriter|null
     */
    public function getWriter(): ?AbstractWriter
    {
        return $this->writer;
    }

    /**
     * @param string|BMPWriter|GIFWriter|JPEGWriter|PNGWriter $writer
     * @return self
     * @throws \Exception
     */
    public function setWriter($writer): self
    {
        switch (true) {
            case \is_string($writer):
                $this->writer = $this->writerManager->getWriter($writer);
                break;

            case \is_subclass_of($writer, AbstractWriter::class):
                $this->writer = $writer;
                break;

            default:
                throw new \Exception('Suggested Writer is not supported.');
        }

        return $this;
    }

    /*
    public function getReader(string $class): AbstractReader
    {
        return $this->readerManager->getReader($class);
    }

    public function getWriter(string $class): AbstractWriter
    {
        return $this->writerManager->getWriter($class);
    }
    */


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