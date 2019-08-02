<?php
/**
 * (c) Przemek Wiejak <przmek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WP\ImageCrop\Reader;

/**
 * Class JPEG
 *
 * @package WP\ImageCrop\Reader
 */
class JPEG extends AbstractReader
{
    /**
     * @return JPEG
     * @throws \Exception
     */
    public function load(): self
    {
        try {
            $this->resource = \imagecreatefromjpeg($this->pathSource);
        } catch (\Exception $exception) {
            throw new \Exception(\sprintf('Provided file is not compatible with %s reader.', $this->getShortName()));
        }

        return $this;
    }
}
