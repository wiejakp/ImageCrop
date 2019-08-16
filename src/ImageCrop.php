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

        $modified = \imagecrop(
            $original,
            ['x' => 0, 'y' => $top, 'width' => \imagesx($original), 'height' => (\imagesy($original) - $top)]
        );

        $reader->setResource($modified);

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

        $modified = \imagecrop(
            $original,
            ['x' => 0, 'y' => 0, 'width' => (\imagesx($original) - $right), 'height' => \imagesy($original)]
        );

        $reader->setResource($modified);

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

        $modified = \imagecrop(
            $original,
            ['x' => 0, 'y' => 0, 'width' => \imagesx($original), 'height' => (\imagesy($original) - $bottom)]
        );

        $reader->setResource($modified);

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

        $modified = \imagecrop(
            $original,
            ['x' => $left, 'y' => 0, 'width' => (\imagesx($original) - $left), 'height' => \imagesy($original)]
        );

        $reader->setResource($modified);

        return $this;
    }

    /**
     * @param AbstractReader $reader
     * @return self
     */
    public function cropY(AbstractReader $reader): self
    {
        $original = $reader->getResource();

        // image parameters
        $top = 0;
        $right = null;
        $bottom = 0;
        $left = null;

        // find most top non-white pixel
        for (; $top < \imagesy($original); ++$top) {
            for ($x = 0; $x < \imagesx($original); ++$x) {
                if (\imagecolorat($original, $x, $top) != 0xFFFFFF) {
                    break 2;
                }
            }
        }

        // find most bottom non-white pixel
        for (; $bottom < \imagesy($original); ++$bottom) {
            for ($x = 0; $x < imagesx($original); ++$x) {
                if (\imagecolorat($original, $x, \imagesy($original) - $bottom - 1) != 0xFFFFFF) {
                    break 2;
                }
            }
        }

        $modified = \imagecrop(
            $original,
            ['x' => 0, 'y' => $top, 'width' => \imagesx($original), 'height' => (\imagesy($original) - ($top + $bottom))]
        );

        $reader->setResource($modified);

        /*
        \imagejpeg( // create image resource
            \imagecrop( // crop resource
                $resource,
                ['x' => 0, 'y' => $top, 'width' => \imagesx($resource), 'height' => (\imagesy($resource) - ($top + $bottom))]
            ),
            $reader->getDestination(),
            100
        );
        */

        return $this;
    }

    /**
     * @param AbstractReader $reader
     * @return string
     */
    public function contents(AbstractReader $reader): string
    {
        return \file_get_contents($reader->getDestination());
    }
}