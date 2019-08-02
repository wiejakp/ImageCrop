<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WP\ImageCrop;

use WP\ImageCrop\Manager\ReaderManager;
use WP\ImageCrop\Reader\AbstractReader;

/**
 * Class ImageCrop
 *
 * @package WP\ImageCrop
 */
class ImageCrop
{
    /**
     * @var ReaderManager
     */
    private $readerManager;

    public function __construct()
    {
        $this->readerManager = new ReaderManager();
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
     * @param AbstractReader $reader
     * @return self
     */
    public function cropY(AbstractReader $reader): self
    {
        $resource = $reader->getResource();

        // image parameters
        $top = 0;
        $right = null;
        $bottom = 0;
        $left = null

        // find most top non-white pixel
        for (; $top < \imagesy($resource); ++$top) {
            for ($x = 0; $x < \imagesx($resource); ++$x) {
                if (\imagecolorat($resource, $x, $top) != 0xFFFFFF) {
                    break 2;
                }
            }
        }

        // find most bottom non-white pixel
        for (; $bottom < \imagesy($resource); ++$bottom) {
            for ($x = 0; $x < imagesx($resource); ++$x) {
                if (\imagecolorat($resource, $x, \imagesy($resource) - $bottom - 1) != 0xFFFFFF) {
                    break 2;
                }
            }
        }

        \imagejpeg( // create image resource
            \imagecrop( // crop resource
                $resource,
                ['x' => 0, 'y' => $top, 'width' => \imagesx($resource), 'height' => (\imagesy($resource) - ($top + $bottom))]
            ),
            $reader->getDestination(),
            100
        );

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