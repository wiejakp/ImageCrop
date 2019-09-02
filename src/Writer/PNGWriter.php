<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Writer;

use wiejakp\ImageCrop\Manager\WriterManager;

/**
 * Class PNGWriter
 */
class PNGWriter extends AbstractWriter
{
    /**
     * JPEGWriter constructor.
     *
     * @param WriterManager $manager
     */
    public function __construct(WriterManager $manager)
    {
        parent::__construct($manager);

        $this->class = \get_class($this);
    }

    /**
     * @param int $quality
     *
     * @return string
     */
    public function write($quality = 0): string
    {
        $resource = $this->getManager()->getCore()->getReader()->getResource();

        if (false !== $resource) {
            \imagepng($resource, $this->getPath(), $quality);
        }

        return $this->getPath();
    }
}
