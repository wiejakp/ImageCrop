<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test\Reader;

use wiejakp\ImageCrop\Exception\NullReaderException;
use wiejakp\ImageCrop\Exception\NullResourceException;
use wiejakp\ImageCrop\ImageCrop;
use wiejakp\ImageCrop\Manager\ReaderManager;
use wiejakp\ImageCrop\Reader\AbstractReader;
use wiejakp\ImageCrop\Reader\BMPReader;
use wiejakp\ImageCrop\Reader\GIFReader;
use wiejakp\ImageCrop\Reader\JPEGReader;
use wiejakp\ImageCrop\Reader\PNGReader;
use wiejakp\ImageCrop\Test\TestImageCase;

/**
 * @inheritDoc
 */
class AbstractReaderTest extends TestImageCase
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
    public function testNullReaderException(string $class, string $path): void
    {
        // test empty reader
        $this->expectException(NullReaderException::class);
        $this->core->getReader();
    }

    /**
     * @dataProvider data
     *
     * @param string $class
     * @param string $path
     */
    public function testNullResourceException(string $class, string $path): void
    {
        // test empty resource
        $this->expectException(NullResourceException::class);

        /** @var AbstractReader $reader */
        $reader = new $class($this->core->getReaderManager());
        $reader->getResource();
    }

    /**
     * @dataProvider data
     *
     * @param string $class
     * @param string $path
     */
    public function testReader(string $class, string $path)
    {
        // test reader manager
        $this->assertInstanceOf(ReaderManager::class, $this->core->getReaderManager());

        // test set reader
        $this->core->setReader($class);
        $this->assertInstanceOf($class, $this->core->getReader());

        // test provided resource file
        $this->assertFileExists($path);
        $this->assertIsReadable($path);

        // test loaded resource file
        $this->core->getReader()->loadFromPath($path);
        $this->assertIsResource($this->core->getReader()->getResource());
    }

    /**
     * @return iterable
     */
    public function data(): iterable
    {
        yield [BMPReader::class, $this->createEmptyBMP()];
        yield [GIFReader::class, $this->createEmptyGIF()];
        yield [JPEGReader::class, $this->createEmptyJPEG()];
        yield [PNGReader::class, $this->createEmptyPNG()];
    }
}
