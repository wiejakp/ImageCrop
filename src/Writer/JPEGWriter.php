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
 * Class JPEGWriter
 *
 * @package wiejakp\ImageCrop\Writer
 */
class JPEGWriter extends AbstractWriter
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

    public function write(AbstractReader $reader): string
    {
        $resource = $reader->getResource();
        dd($resource);
    }
}
