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

/**
 * Class ImageCropTest
 * @package wiejakp\ImageCrop\Test
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
        // initialize library core
        $core = new ImageCrop();

        // create reflection property object for ImageCrop::$reader
        $manager = new ReflectionProperty(ImageCrop::class, 'readerManager');
        $manager->setAccessible(true);
        $manager = $manager->getValue($core);

        // create reflection property object for ImageCrop::$reader
        $property = new ReflectionProperty(ImageCrop::class, 'reader');
        $property->setAccessible(true);

        // test empty reader
        $this->assertNull($property->getValue($core));

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
}
