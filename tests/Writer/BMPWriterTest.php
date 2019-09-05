<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test\Reader;

use wiejakp\ImageCrop\ImageCrop;
use wiejakp\ImageCrop\Manager\ReaderManager;
use wiejakp\ImageCrop\Manager\WriterManager;
use wiejakp\ImageCrop\Reader\BMPReader;
use wiejakp\ImageCrop\Test\TestImageCase;
use wiejakp\ImageCrop\Writer\BMPWriter;

/**
 * @inheritDoc
 */
class BMPWriterTest extends TestImageCase
{
    /**
     * @var ImageCrop
     */
    private $core;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $data;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->core = new ImageCrop();
        $this->core->setReader(new BMPReader(new ReaderManager($this->core)));
        $this->core->setWriter(new BMPWriter(new WriterManager($this->core)));
        $this->path = $this->core->getWriter()->getPath();
        $this->data = \file_get_contents($this->createEmptyBMP());

        \file_put_contents($this->path, $this->data);
    }
}
