<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test\Writer;

use wiejakp\ImageCrop\Exception\NullReaderException;
use wiejakp\ImageCrop\Exception\NullResourceException;
use wiejakp\ImageCrop\Exception\NullWriterException;
use wiejakp\ImageCrop\ImageCrop;
use wiejakp\ImageCrop\Manager\ReaderManager;
use wiejakp\ImageCrop\Manager\WriterManager;
use wiejakp\ImageCrop\Reader\AbstractReader;
use wiejakp\ImageCrop\Reader\BMPReader;
use wiejakp\ImageCrop\Reader\GIFReader;
use wiejakp\ImageCrop\Reader\JPEGReader;
use wiejakp\ImageCrop\Reader\PNGReader;
use wiejakp\ImageCrop\Test\TestImageCase;
use wiejakp\ImageCrop\Writer\AbstractWriter;
use wiejakp\ImageCrop\Writer\BMPWriter;
use wiejakp\ImageCrop\Writer\GIFWriter;
use wiejakp\ImageCrop\Writer\JPEGWriter;
use wiejakp\ImageCrop\Writer\PNGWriter;

/**
 * @inheritDoc
 */
class AbstractWriterTest extends TestImageCase
{
    /**
     * @var ImageCrop
     */
    private $core;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->core = new ImageCrop();
    }

    /**
     * @dataProvider data
     *
     * @param string $class
     * @param string $path
     */
    public function testNullWriterException(string $class, string $path): void
    {
        // test empty reader
        $this->expectException(NullWriterException::class);

        $this->core->getWriter();
    }

    /**
     * @dataProvider data
     *
     * @param string $class
     * @param string $path
     */
    public function testWriter(string $class, string $path)
    {
        // test writer manager
        $this->assertInstanceOf(WriterManager::class, $this->core->getWriterManager());

        // test set reader
        $this->core->setWriter($class);
        $this->assertInstanceOf($class, $this->core->getWriter());
    }

    /**
     * @return iterable
     */
    public function data(): iterable
    {
        yield [BMPWriter::class, $this->createBMP()];
        yield [GIFWriter::class, $this->createGIF()];
        yield [JPEGWriter::class, $this->createJPEG()];
        yield [PNGWriter::class, $this->createPNG()];
    }
}
