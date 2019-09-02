<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test;

use ReflectionProperty;
use wiejakp\ImageCrop\ImageCrop;
use wiejakp\ImageCrop\Manager\ReaderManager;
use wiejakp\ImageCrop\Manager\WriterManager;
use wiejakp\ImageCrop\Reader\BMPReader;
use wiejakp\ImageCrop\Reader\GIFReader;
use wiejakp\ImageCrop\Reader\JPEGReader;
use wiejakp\ImageCrop\Reader\PNGReader;
use wiejakp\ImageCrop\Writer\BMPWriter;
use wiejakp\ImageCrop\Writer\GIFWriter;
use wiejakp\ImageCrop\Writer\JPEGWriter;
use wiejakp\ImageCrop\Writer\PNGWriter;

/**
 * @inheritDoc
 */
class ImageCropTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstruct(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // create reflection objects for properties set up while core initialisation
        $readerManagerProperty = new ReflectionProperty(ImageCrop::class, 'readerManager');
        $writerManagerProperty = new ReflectionProperty(ImageCrop::class, 'writerManager');

        // set reflected properties as accessible core properties
        $readerManagerProperty->setAccessible(true);
        $writerManagerProperty->setAccessible(true);

        $this->assertSame(ReaderManager::class, \get_class($readerManagerProperty->getValue($core)));
        $this->assertSame(WriterManager::class, \get_class($writerManagerProperty->getValue($core)));
    }

    /**
     * @return void
     */
    public function testGetReader(): void
    {
        $this->testReader();
    }

    /**
     * @return void
     */
    public function testSetReader(): void
    {
        $this->testReader();
    }

    /**
     * @return void
     */
    public function testGetWriter(): void
    {
        $this->testWriter();
    }

    /**
     * @return void
     */
    public function testSetWriter(): void
    {
        $this->testWriter();
    }

    /**
     * @return void
     */
    public function testGetRGBA(): void
    {
        $this->testRGBA();
    }

    /**
     * @return void
     */
    public function testSetRGBA(): void
    {
        $this->testRGBA();
    }

    /**
     * @return void
     */
    public function testisEmpty(): void
    {
        $this->testEmpty();
    }

    /**
     * @return void
     */
    public function testSetEmpty(): void
    {
        $this->testEmpty();
    }

    /**
     * test get/set ImageCrop::$reader
     *
     * @return void
     */
    public function testReader(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // create reflection property object for ImageCrop::$reader
        $property = new ReflectionProperty(ImageCrop::class, 'reader');
        $property->setAccessible(true);

        // test empty reader
        $this->assertNull($property->getValue($core));

        // create reflection property object for ImageCrop::$reader
        $manager = new ReflectionProperty(ImageCrop::class, 'readerManager');
        $manager->setAccessible(true);
        $manager = $manager->getValue($core);

        // test set readers by reader class name
        $core->setReader(BMPReader::class);
        $this->assertSame(BMPReader::class, \get_class($core->getReader()));
        $core->setReader(GIFReader::class);
        $this->assertSame(GIFReader::class, \get_class($core->getReader()));
        $core->setReader(JPEGReader::class);
        $this->assertSame(JPEGReader::class, \get_class($core->getReader()));
        $core->setReader(PNGReader::class);
        $this->assertSame(PNGReader::class, \get_class($core->getReader()));

        // test set readers by reader object
        $core->setReader(new BMPReader($manager));
        $this->assertSame(BMPReader::class, \get_class($core->getReader()));
        $core->setReader(new GIFReader($manager));
        $this->assertSame(GIFReader::class, \get_class($core->getReader()));
        $core->setReader(new JPEGReader($manager));
        $this->assertSame(JPEGReader::class, \get_class($core->getReader()));
        $core->setReader(new PNGReader($manager));
        $this->assertSame(PNGReader::class, \get_class($core->getReader()));
    }

    /**
     * test get/set ImageCrop::$writer
     *
     * @return void
     */
    public function testWriter(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // create reflection property object for ImageCrop::$reader
        $property = new ReflectionProperty(ImageCrop::class, 'writer');
        $property->setAccessible(true);

        // test empty writer
        $this->assertNull($property->getValue($core));

        // create reflection property object for ImageCrop::$writer
        $manager = new ReflectionProperty(ImageCrop::class, 'writerManager');
        $manager->setAccessible(true);
        $manager = $manager->getValue($core);

        // test set writers by writer class name
        $core->setWriter(BMPWriter::class);
        $this->assertSame(BMPWriter::class, \get_class($core->getWriter()));
        $core->setWriter(GIFWriter::class);
        $this->assertSame(GIFWriter::class, \get_class($core->getWriter()));
        $core->setWriter(JPEGWriter::class);
        $this->assertSame(JPEGWriter::class, \get_class($core->getWriter()));
        $core->setWriter(PNGWriter::class);
        $this->assertSame(PNGWriter::class, \get_class($core->getWriter()));

        // test set writers by writer object
        $core->setWriter(new BMPWriter($manager));
        $this->assertSame(BMPWriter::class, \get_class($core->getWriter()));
        $core->setWriter(new GIFWriter($manager));
        $this->assertSame(GIFWriter::class, \get_class($core->getWriter()));
        $core->setWriter(new JPEGWriter($manager));
        $this->assertSame(JPEGWriter::class, \get_class($core->getWriter()));
        $core->setWriter(new PNGWriter($manager));
        $this->assertSame(PNGWriter::class, \get_class($core->getWriter()));
    }

    /**
     * test get/set ImageCrop::$rgba
     *
     * @return void
     */
    public function testRGBA(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // test default
        $this->assertSame(['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 0], $core->getRGBA());

        // test changed
        $core->setRGBA(0, 0, 0, 0);
        $this->assertSame(['red' => 0, 'green' => 0, 'blue' => 0, 'alpha' => 0], $core->getRGBA());
    }

    /**
     * test get/set ImageCrop::$empty
     *
     * @return void
     */
    public function testEmpty(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // test default
        $this->assertSame(false, $core->isEmpty());

        // test changed
        $property = new ReflectionProperty(ImageCrop::class, 'empty');
        $property->setAccessible(true);
        $property->setValue($core, true);
        $this->assertSame(true, $core->isEmpty());
    }
}
