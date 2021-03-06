<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test;

use DataURI\Data;
use DataURI\Dumper;
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
class ImageCropTest extends TestImageCase
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
    public function testIsEmpty(): void
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

        // test set readers by reader class name
        $core->setReader(BMPReader::class);
        $this->assertSame(BMPReader::class, \get_class($core->getReader()));
        $core->setReader(GIFReader::class);
        $this->assertSame(GIFReader::class, \get_class($core->getReader()));
        $core->setReader(JPEGReader::class);
        $this->assertSame(JPEGReader::class, \get_class($core->getReader()));
        $core->setReader(PNGReader::class);
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

        // test set writers by writer class name
        $core->setWriter(BMPWriter::class);
        $this->assertSame(BMPWriter::class, \get_class($core->getWriter()));
        $core->setWriter(GIFWriter::class);
        $this->assertSame(GIFWriter::class, \get_class($core->getWriter()));
        $core->setWriter(JPEGWriter::class);
        $this->assertSame(JPEGWriter::class, \get_class($core->getWriter()));
        $core->setWriter(PNGWriter::class);
        $this->assertSame(PNGWriter::class, \get_class($core->getWriter()));
    }

    /**
     * @return void
     */
    public function testCrop(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // get resource file path
        $path = $core->getWriter()->getPath();

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG());

        // save original image to the drive
        $core->getWriter()->write();

        // get size of original resource
        list($originalWidth, $originalHeight) = \getimagesize($path);

        // perform crop
        $core->crop();

        // save cropped image to the drive
        $core->getWriter()->write();

        // get size of cropped resource
        list($croppedWidth, $croppedHeight) = \getimagesize($path);

        // perform tests
        $this->assertSame($croppedWidth, ($originalWidth - (2 * $this->getBorder())));
        $this->assertSame($croppedHeight, ($originalHeight - (2 * $this->getBorder())));
    }

    /**
     * @return void
     */
    public function testCropTop(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // get resource file path
        $path = $core->getWriter()->getPath();

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG());

        // save original image to the drive
        $core->getWriter()->write();

        // get size of original resource
        list($originalWidth, $originalHeight) = \getimagesize($path);

        // perform crop
        $core->cropTop();

        // save cropped image to the drive
        $core->getWriter()->write();

        // get size of cropped resource
        list($croppedWidth, $croppedHeight) = \getimagesize($path);

        // perform tests
        $this->assertSame($croppedWidth, $originalWidth);
        $this->assertSame($croppedHeight, ($originalHeight - $this->getBorder()));
    }

    /**
     * @return void
     */
    public function testCropRight(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // get resource file path
        $path = $core->getWriter()->getPath();

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG());

        // save original image to the drive
        $core->getWriter()->write();

        // get size of original resource
        list($originalWidth, $originalHeight) = \getimagesize($path);

        // perform crop
        $core->cropRight();

        // save cropped image to the drive
        $core->getWriter()->write();

        // get size of cropped resource
        list($croppedWidth, $croppedHeight) = \getimagesize($path);

        // perform tests
        $this->assertSame($croppedWidth, ($originalWidth - $this->getBorder()));
        $this->assertSame($croppedHeight, $originalHeight);
    }

    /**
     * @return void
     */
    public function testCropBottom(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // get resource file path
        $path = $core->getWriter()->getPath();

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG());

        // save original image to the drive
        $core->getWriter()->write();

        // get size of original resource
        list($originalWidth, $originalHeight) = \getimagesize($path);

        // perform crop
        $core->cropBottom();

        // save cropped image to the drive
        $core->getWriter()->write();

        // get size of cropped resource
        list($croppedWidth, $croppedHeight) = \getimagesize($path);

        // perform tests
        $this->assertSame($croppedWidth, $originalWidth);
        $this->assertSame($croppedHeight, ($originalHeight - $this->getBorder()));
    }

    /**
     * @return void
     */
    public function testCropLeft(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // get resource file path
        $path = $core->getWriter()->getPath();

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG());

        // save original image to the drive
        $core->getWriter()->write();

        // get size of original resource
        list($originalWidth, $originalHeight) = \getimagesize($path);

        // perform crop
        $core->cropLeft();

        // save cropped image to the drive
        $core->getWriter()->write();

        // get size of cropped resource
        list($croppedWidth, $croppedHeight) = \getimagesize($path);

        // perform tests
        $this->assertSame($croppedWidth, ($originalWidth - $this->getBorder()));
        $this->assertSame($croppedHeight, $originalHeight);
    }

    /**
     * @return void
     */
    public function testCropTopEmpty(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG(0, 1));

        // perform crop
        $core->cropTop();

        $this->assertTrue($core->isEmpty());
    }

    /**
     * @return void
     */
    public function testCropRightEmpty(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG(0, 1));

        // perform crop
        $core->cropRight();

        $this->assertTrue($core->isEmpty());
    }

    /**
     * @return void
     */
    public function testCropBottomEmpty(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG(0, 1));

        // perform crop
        $core->cropBottom();

        $this->assertTrue($core->isEmpty());
    }

    /**
     * @return void
     */
    public function testCropLeftEmpty(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG(0, 1));

        // perform crop
        $core->cropLeft();

        $this->assertTrue($core->isEmpty());
    }

    /**
     * @return void
     */
    public function testData(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // get resource file path
        $path = $core->getWriter()->getPath();

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG());

        // save original image to the drive
        $core->getWriter()->write();

        $expected = \file_get_contents($path);
        $actual = $core->getData();

        $this->assertSame($expected, $actual);
    }

    /**
     * @return void
     */
    public function testDataUri(): void
    {
        // initialize library core
        $core = new ImageCrop();

        // configure image reader and writer
        $core
            ->setReader(JPEGReader::class)
            ->setWriter(JPEGWriter::class);

        // get resource file path
        $path = $core->getWriter()->getPath();

        // load resource into a reader
        $core->getReader()->loadFromPath($this->createJPEG());

        // save original image to the drive
        $core->getWriter()->write();

        $expected = Dumper::dump(
            new Data(\file_get_contents($path), $core->getReaderManager()->getDataMimeType($path))
        );
        $actual = $core->getDataUri();

        $this->assertSame($expected, $actual);
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
        $this->assertTrue($core->isEmpty());
    }
}
