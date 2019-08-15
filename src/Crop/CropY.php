<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Crop;

/**
 * Class CropY
 *
 * @package wiejakp\ImageCrop\Crop
 */
class CropY extends AbstractCrop
{
    /**
     * @return int|null
     */
    public function getX(): ?int
    {
        return 0;
    }

    /**
     * @return int|null
     */
    public function getY(): ?int
    {
        return $this->top;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return \imagesx($this->resource);
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return \imagesy($this->resource) - ($this->top + $this->bottom);
    }
}
