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
 * Class ImageCrop
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
     * @var array
     */
    private $rgba = ['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 0];

    /**
     * @var bool
     */
    private $empty = false;

    /**
     * ImageCrop constructor.
     */
    public function __construct()
    {
        $this->readerManager = new ReaderManager($this);
        $this->writerManager = new WriterManager($this);
    }

    /**
     * @return ReaderManager
     */
    public function getReaderManager(): ReaderManager
    {
        return $this->readerManager;
    }

    /**
     * @return WriterManager
     */
    public function getWriterManager(): WriterManager
    {
        return $this->writerManager;
    }

    /**
     * @inheritDoc
     */
    public function getReader(): AbstractReader
    {
        return $this->getReaderManager()->getReader();
    }

    /**
     * @inheritDoc
     */
    public function setReader($reader): self
    {
        $this->getReaderManager()->setReader($reader);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getWriter()
    {
        return $this->getWriterManager()->getWriter();
    }

    /**
     * @inheritDoc
     */
    public function setWriter($writer): self
    {
        $this->getWriterManager()->setWriter($writer);

        return $this;
    }

    /**
     * @return array
     */
    public function getRGBA(): array
    {
        return $this->rgba;
    }

    /**
     * @param int $red
     * @param int $green
     * @param int $blue
     * @param int $alpha
     *
     * @return self
     */
    public function setRGBA(int $red, int $green, int $blue, int $alpha): self
    {
        $this->rgba = ['red' => $red, 'green' => $green, 'blue' => $blue, 'alpha' => $alpha];

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->empty;
    }

    /**
     * @return self
     */
    public function cropTop(): self
    {
        $reader = $this->getReaderManager()->getReader();
        $original = $reader->getResource();
        $top = 0;

        for (; $top < \imagesy($original); ++$top) {
            for ($x = 0; $x < \imagesx($original); ++$x) {
                if (false === $this->isColorMatch($original, $x, $top)) {
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

        if (false !== $modified) {
            $reader->setResource($modified);
        }

        return $this;
    }

    /**
     * @return self
     */
    public function cropRight(): self
    {
        $reader = $this->getReaderManager()->getReader();
        $original = $reader->getResource();
        $right = 0;

        for (; $right < \imagesx($original); ++$right) {
            for ($y = 0; $y < \imagesy($original); ++$y) {
                if (false === $this->isColorMatch($original, \imagesx($original) - $right, $y)) {
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

        if (false !== $modified) {
            $reader->setResource($modified);
        }

        return $this;
    }

    /**
     * @return self
     */
    public function cropBottom(): self
    {
        $reader = $this->getReaderManager()->getReader();
        $original = $reader->getResource();
        $bottom = 0;

        for (; $bottom < \imagesy($original); ++$bottom) {
            for ($x = 0; $x < \imagesx($original); ++$x) {
                if (false === $this->isColorMatch($original, $x, \imagesy($original) - $bottom - 1)) {
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

        if (false !== $modified) {
            $reader->setResource($modified);
        }

        return $this;
    }

    /**
     * @return self
     */
    public function cropLeft(): self
    {
        $reader = $this->getReaderManager()->getReader();
        $original = $reader->getResource();
        $left = 0;

        for (; $left < \imagesx($original); ++$left) {
            for ($y = 0; $y < \imagesy($original); ++$y) {
                if (false === $this->isColorMatch($original, $left, $y)) {
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

        if (false !== $modified) {
            $reader->setResource($modified);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->getWriterManager()->getData($this->getWriter()->getPath());
    }

    /**
     * @return string
     */
    public function getDataUri(): string
    {
        return $this->getWriterManager()->getDataUri($this->getWriter()->getPath());
    }

    /**
     * @param resource $resource
     * @param int      $x
     * @param int      $y
     *
     * @return bool
     */
    private function isColorMatch($resource, int $x, int $y): bool
    {
        list($ar, $ag, $ab, $aa) = \array_values($this->getRGBA());
        list($br, $bg, $bb, $ba) = \array_values(\imagecolorsforindex($resource, \imagecolorat($resource, $x, $y)));

        return $ar === $br && $ag === $bg && $ab === $bb && $aa <= $ba;
    }
}
