<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test\Exception;

use wiejakp\ImageCrop\Exception\ReaderNotFoundException;
use wiejakp\ImageCrop\Exception\WriterNotFoundException;
use wiejakp\ImageCrop\Test\TestCase;

/**
 * @inheritDoc
 */
class WriterNotFoundExceptionTest extends TestCase
{
    /**
     * @throws WriterNotFoundException
     */
    public function testConstruct(): void
    {
        $this->expectException(WriterNotFoundException::class);

        throw new WriterNotFoundException();
    }
}
