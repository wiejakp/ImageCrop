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
 * Class BMPWriter
 */
class BMPWriter extends AbstractWriter
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
     * @param bool $compressed
     *
     * @return string
     */
    public function write($compressed = false): string
    {
        $resource = $this->getManager()->getCore()->getReader()->getResource();

        if (false !== $resource) {
            \imagebmp($resource, $this->getPath(), $compressed);
        }

        return $this->getPath();
    }
}
