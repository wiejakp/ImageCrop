<?php
/**
 * (c) Przemek Wiejak <przmek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WP\ImageCrop;

use WP\ImageCrop\Core\Manager;
use WP\ImageCrop\Reader\AbstractReader;

/**
 * Class ImageCrop
 *
 * @package WP\ImageCrop
 */
class ImageCrop
{
    private $manager;

    /**
     * @var string
     */
    private $pathSource;

    /**
     * @var AbstractReader|null
     */
    private $reader;

    /**
     * ImageCrop constructor.
     *
     * @param string $pathSource
     */
    public function __construct(string $pathSource)
    {
        $this->manager = new Manager(__FILE__);
        $this->pathSource = $pathSource;
    }

    /**
     * @return AbstractReader|null
     */
    public function getReader(): ?AbstractReader
    {
        return $this->reader;
    }

    /**
     * @param string $reader
     * @return self
     */
    public function setReader(string $reader): self
    {
        $this->reader = $reader;
        return $this;
    }


    public function vertical(string $path): string
    {
        // create temp file path
        $temp = \tempnam(\sys_get_temp_dir(), 'image_');

        // create image resource
        $image = \imagecreatefromjpeg($path);

        // image parameters
        $top = 0;
        $bottom = 0;

        // find most top non-white pixel
        for (; $top < \imagesy($image); ++$top) {
            for ($x = 0; $x < \imagesx($image); ++$x) {
                if (\imagecolorat($image, $x, $top) != 0xFFFFFF) {
                    break 2;
                }
            }
        }

        // find most bottom non-white pixel
        for (; $bottom < \imagesy($image); ++$bottom) {
            for ($x = 0; $x < imagesx($image); ++$x) {
                if (\imagecolorat($image, $x, \imagesy($image) - $bottom - 1) != 0xFFFFFF) {
                    break 2;
                }
            }
        }

        \imagejpeg( // create image resource
            \imagecrop( // crop resource
                $image,
                ['x' => 0, 'y' => $top, 'width' => \imagesx($image), 'height' => (\imagesy($image) - ($top + $bottom))]
            ),
            $temp,
            100
        );

        return $temp;
    }
}
