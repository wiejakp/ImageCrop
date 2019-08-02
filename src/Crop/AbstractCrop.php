<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WP\ImageCrop\Crop;

/**
 * Class AbstractCrop
 *
 * @package WP\ImageCrop\Crop
 */
abstract class AbstractCrop
{
    /**
     * @var resource
     */
    protected $resource;

    /**
     * @var int|null
     */
    protected $top;

    /**
     * @var int|null
     */
    protected $right;

    /**
     * @var int|null
     */
    protected $bottom;

    /**
     * @var int|null
     */
    protected $left;

    /**
     * AbstractCrop constructor.
     *
     * @param resource $resource
     * @param int|null $top
     * @param int|null $right
     * @param int|null $bottom
     * @param int|null $left
     * @throws \Exception
     */
    public function __construct($resource)
    {
        if (false === is_resource($resource)) {
            throw new \Exception('Image Resource Is Required!');
        }

        $this->resource = $resource;
        $this->top = 0;
        $this->right = null;
        $this->bottom = null;
        $this->left = null;
    }

    /**
     * @return int|null
     */
    public function getX(): ?int
    {
        return null;
    }

    /**
     * @return int|null
     */
    public function getY(): ?int
    {
        return null;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return null;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return null;
    }

    /**
     * @return array
     */
    public function getImageCropArray(): array
    {
        return [
            'x'      => $this->getX(),
            'y'      => $this->getY(),
            'width'  => $this->getWidth(),
            'height' => $this->getHeight(),
        ];
    }

    /**
     * @return void
     */
    public function cropTop(): void
    {
        $top = $this->top;
        $resource = $this->resource;

        for (; $top < \imagesy($resource); ++$top) {
            for ($x = 0; $x < \imagesx($resource); ++$x) {
                if (\imagecolorat($resource, $x, $top) != 0xFFFFFF) {
                    break 2;
                }
            }
        }
    }

    /**
     * @return void
     */
    public function cropBottom(): void
    {
        $bottom = $this->bottom;
        $resource = $this->resource;

        for (; $bottom < \imagesy($resource); ++$bottom) {
            for ($x = 0; $x < imagesx($resource); ++$x) {
                if (\imagecolorat($resource, $x, \imagesy($resource) - $bottom - 1) != 0xFFFFFF) {
                    break 2;
                }
            }
        }
    }
}
