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
use wiejakp\ImageCrop\Reader\JPEGReader;
use wiejakp\ImageCrop\Test\TestImageCase;
use wiejakp\ImageCrop\Writer\JPEGWriter;

/**
 * @inheritDoc
 */
class JPEGReaderTest extends TestImageCase
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
        $this->core->setReader(new JPEGReader(new ReaderManager($this->core)));
        $this->core->setWriter(new JPEGWriter(new WriterManager($this->core)));
        $this->path = $this->core->getWriter()->getPath();
        $this->data = \file_get_contents($this->createJPEG());

        \file_put_contents($this->path, $this->data);
    }

    /**
     * @return void
     */
    public function testConstruct(): void
    {
        $this->assertInstanceOf(JPEGReader::class, $this->core->getReader());
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
