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

/**
 * Class AbstractManagerTest
 */
class AbstractManagerTest extends MockeryTestCase
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
}
