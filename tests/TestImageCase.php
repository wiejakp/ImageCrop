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
    private $offset = 5;

    /**
     * @param int $border
     *
     * @return string
     */
    public function createBMP(int $border = 0): string
    {
        $path = $this->getTempFile();

        $resource = \imagecreatetruecolor($this->offset, $this->offset);
        $color = \imagecolorallocate($resource, 0, 0, 0);

        // fill image with color
        \imagefilledrectangle($resource, 0, 0, 0, 0, $color);

        // add image border when needed
        $this->addImageBorder($resource, $border);

        // save image resource to a file
        \imagebmp($resource, $path, false);

        return $path;
    }

    /**
     * @param int $border
     *
     * @return string
     */
    public function createGIF(int $border = 0): string
    {
        $path = $this->getTempFile();

        $resource = \imagecreatetruecolor($this->offset, $this->offset);
        $color = \imagecolorallocate($resource, 0, 0, 0);

        // fill image with color
        \imagefilledrectangle($resource, 0, 0, 0, 0, $color);

        // add image border when needed
        $this->addImageBorder($resource, $border);

        // save image resource to a file
        \imagegif($resource, $path);

        return $path;
    }

    /**
     * @param int $border
     *
     * @return string
     */
    public function createJPEG(int $border = 0): string
    {
        $path = $this->getTempFile();

        $resource = \imagecreatetruecolor($this->offset, $this->offset);
        $color = \imagecolorallocate($resource, 0, 0, 0);

        // fill image with color
        \imagefilledrectangle($resource, 0, 0, 0, 0, $color);

        // add image border when needed
        $this->addImageBorder($resource, $border);

        // save image resource to a file
        \imagejpeg($resource, $path, 100);

        return $path;
    }

    /**
     * @param int $border
     *
     * @return string
     */
    public function createPNG(int $border = 0): string
    {
        $path = $this->getTempFile();

        $resource = \imagecreatetruecolor($this->offset, $this->offset);
        $color = \imagecolorallocate($resource, 0, 0, 0);

        // fill image with color
        \imagefilledrectangle($resource, 0, 0, 0, 0, $color);

        // add image border when needed
        $this->addImageBorder($resource, $border);

        // save image resource to a file
        \imagepng($resource, $path, 0);

        return $path;
    }

    /**
     * @param     $original
     * @param int $border
     */
    function addImageBorder(&$original, int $border): void
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
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return string
     */
    protected function getTempFile(): string
    {
        $path = \tempnam(\sys_get_temp_dir(), \sprintf('%s_', 'image'));

        return $path;
    }
}
