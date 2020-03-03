<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test\Manager;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use wiejakp\ImageCrop\ImageCrop;
use wiejakp\ImageCrop\Reader\BMPReader;
use wiejakp\ImageCrop\Reader\GIFReader;
use wiejakp\ImageCrop\Reader\JPEGReader;
use wiejakp\ImageCrop\Reader\PNGReader;
use wiejakp\ImageCrop\Writer\BMPWriter;
use wiejakp\ImageCrop\Writer\GIFWriter;
use wiejakp\ImageCrop\Writer\JPEGWriter;
use wiejakp\ImageCrop\Writer\PNGWriter;

/**
 * Class AbstractManagerTest
 */
class AbstractManagerTest extends MockeryTestCase
{
    /**
     * @inheritDoc
     */
    public function testReaders(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // create reflection property object for ImageCrop::$reader
        $manager = $core->getReaderManager();

        // get list of library objects
        $libraries = $manager->getReaders();

        $this->assertNotEmpty($libraries);
    }

    /**
     * @inheritDoc
     */
    public function testWriters(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // create reflection property object for ImageCrop::$writer
        $manager = $core->getWriterManager();

        // get list of library objects
        $libraries = $manager->getWriters();

        $this->assertNotEmpty($libraries);
    }

    /**
     * @dataProvider readers
     *
     * @param string $library
     */
    public function testTempFileReaders(string $library): void
    {
        $manager = (new ImageCrop())->getReaderManager();

        // test empty
        $path = $manager->getTempFile();
        $this->assertNotEmpty($path);
        $this->assertFileExists($path);

        // test filled
        $path = $manager->getTempFile($library);
        $this->assertNotEmpty($path);
        $this->assertFileExists($path);
    }

    /**
     * @dataProvider writers
     *
     * @param string $library
     */
    public function testTempFileWriters(string $library): void
    {
        $manager = (new ImageCrop())->getWriterManager();

        // test empty
        $path = $manager->getTempFile();
        $this->assertNotEmpty($path);
        $this->assertFileExists($path);

        // test filled
        $path = $manager->getTempFile($library);
        $this->assertNotEmpty($path);
        $this->assertFileExists($path);
    }

    /**
     * @return iterable
     */
    public function readers(): iterable
    {
        yield [BMPReader::class];
        yield [GIFReader::class];
        yield [JPEGReader::class];
        yield [PNGReader::class];
    }

    /**
     * @return iterable
     */
    public function writers(): iterable
    {
        yield [BMPWriter::class];
        yield [GIFWriter::class];
        yield [JPEGWriter::class];
        yield [PNGWriter::class];
    }
}
