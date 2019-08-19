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
use wiejakp\ImageCrop\Reader\AbstractReader;

/**
 * Class GIFWriter
 *
 * @package wiejakp\ImageCrop\Writer
 */
class GIFWriter extends AbstractWriter
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
     * @param AbstractReader $reader
     * @return string
     */
    public function write(AbstractReader $reader): string
    {
        \imagegif($reader->getResource(), $this->getPath());

        return $this->getPath();
    }
}
