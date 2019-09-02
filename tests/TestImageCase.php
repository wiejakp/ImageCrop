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
     * @return string
     */
    public function createBMP(): string
    {
        $path = $this->getTempFile();

        \imagebmp(\imagecreatetruecolor(1, 1), $path, false);

        return $path;
    }

    /**
     * @return string
     */
    public function createGIF(): string
    {
        $path = $this->getTempFile();

        \imagegif(\imagecreatetruecolor(1, 1), $path);

        return $path;
    }

    /**
     * @return string
     */
    public function createJPEG(): string
    {
        $path = $this->getTempFile();

        \imagejpeg(\imagecreatetruecolor(1, 1), $path, 100);

        return $path;
    }

    /**
     * @return string
     */
    public function createPNG(): string
    {
        $path = $this->getTempFile();

        \imagepng(\imagecreatetruecolor(1, 1), $path, 0);

        return $path;
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
