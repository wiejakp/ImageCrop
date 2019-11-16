<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test;

/**
 * Class TestImageCase
 */
class TestImageCase extends TestCase
{
    /**
     * @var int
     */
    private $size = 5;

    /**
     * @var int
     */
    private $border = 5;

    /**
     * @param int|null $size
     * @param int|null $border
     *
     * @return string
     */
    public function createBMP(int $size = null, int $border = null): string
    {
        $this->init($size, $border);

        $resource = $this->getImageResource();
        $path = $this->getTempFile();

        // save image resource to a file
        \imagebmp($resource, $path, false);

        return $path;
    }

    /**
     * @param int|null $size
     * @param int|null $border
     *
     * @return string
     */
    public function createGIF(int $size = null, int $border = null): string
    {
        $this->init($size, $border);

        $resource = $this->getImageResource();
        $path = $this->getTempFile();

        // save image resource to a file
        \imagegif($resource, $path);

        return $path;
    }

    /**
     * @param int|null $size
     * @param int|null $border
     *
     * @return string
     */
    public function createJPEG(int $size = null, int $border = null): string
    {
        $this->init($size, $border);

        $resource = $this->getImageResource();
        $path = $this->getTempFile();

        // save image resource to a file
        \imagejpeg($resource, $path, 100);

        return $path;
    }

    /**
     * @param int|null $size
     * @param int|null $border
     *
     * @return string
     */
    public function createPNG(int $size = null, int $border = null): string
    {
        $this->init($size, $border);

        $resource = $this->getImageResource();
        $path = $this->getTempFile();

        // save image resource to a file
        \imagepng($resource, $path, 0);

        return $path;
    }

    /**
     * @param mixed $original
     * @param int   $border
     */
    public function addImageBorder(&$original, int $border): void
    {
        if ($border <= 0) {
            return;
        }

        // original resource dimensions
        $originalWidth = \imagesx($original);
        $originalHeight = \imagesy($original);

        // new resource dimensions
        $resourceWidth = $originalWidth + (2 * $border);
        $resourceHeight = $originalHeight + (2 * $border);

        $resource = \imagecreatetruecolor($resourceWidth, $resourceHeight);
        $color = \imagecolorallocate($resource, 255, 255, 255);

        // fill image with color
        \imagefilledrectangle($resource, 0, 0, $resourceWidth, $resourceHeight, $color);

        // modify resource to include border
        \imagecopyresized(
            $resource,
            $original,
            $border,
            $border,
            0,
            0,
            $originalWidth,
            $originalHeight,
            $resourceWidth,
            $resourceHeight
        );

        // replace original resource with one that includes border
        $original = $resource;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return self
     */
    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return int
     */
    public function getBorder(): int
    {
        return $this->border;
    }

    /**
     * @param int $border
     *
     * @return self
     */
    public function setBorder(int $border): self
    {
        $this->border = $border;

        return $this;
    }

    /**
     * @return string
     */
    protected function getTempFile(): string
    {
        $path = \tempnam(\sys_get_temp_dir(), \sprintf('%s_', 'image'));

        return $path;
    }

    /**
     * @param int|null $size
     * @param int|null $border
     */
    private function init(?int $size, ?int $border): void
    {
        $this->size = null === $size ? $this->getSize() : $size;
        $this->border = null === $border ? $this->getBorder() : $border;
    }

    /**
     * @return false|resource
     */
    private function getImageResource()
    {
        $rgb = [0, 0, 0];
        $size = $this->getSize();
        $border = $this->getBorder();

        if (0 === $size) {
            $rgb = [255, 255, 255];
            $size = 1;
            $border = $border === 0 ? 0 : $border - 1;
        }

        $resource = \imagecreatetruecolor($size, $size);
        $color = \imagecolorallocate($resource, $rgb[0], $rgb[1], $rgb[2]);

        // fill image with color
        \imagefilledrectangle($resource, 0, 0, 0, 0, $color);

        // add image border when needed
        $this->addImageBorder($resource, $border);

        return $resource;
    }
}
