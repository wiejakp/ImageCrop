<?php
declare(strict_types=1);

namespace wiejakp\ImageCrop\Test;

use wiejakp\ImageCrop\ImageCrop;

class ImageCropTest extends TestCase
{
    public function testGetHello()
    {
        $object = \Mockery::mock(ImageCrop::class);
        $object->shouldReceive('getHello')->passthru();

        $this->assertSame('Hello, World!', $object->getHello());
    }
}
