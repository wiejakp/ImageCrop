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
use wiejakp\ImageCrop\Reader\GIFReader;
use wiejakp\ImageCrop\Test\TestImageCase;
use wiejakp\ImageCrop\Writer\GIFWriter;

/**
 * @inheritDoc
 */
class GIFReaderTest extends TestImageCase
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
        $this->core->setReader(GIFReader::class);
        $this->core->setWriter(GIFWriter::class);
        $this->path = $this->core->getWriter()->getPath();
        $this->data = \file_get_contents($this->createGIF());

        \file_put_contents($this->path, $this->data);
    }

    /**
     * @return void
     */
    public function testConstruct(): void
    {
        $this->assertInstanceOf(GIFReader::class, $this->core->getReader());
    }

    /**
     * @return void
     */
    public function testLoadFromPath(): void
    {
        $reader = $this->core->getReader();
        $reader->loadFromPath($this->path);

        $writer = $this->core->getWriter();
        $writer->write();

        $this->assertSame($this->data, $writer->getManager()->getData($writer->getPath()));
    }
}
