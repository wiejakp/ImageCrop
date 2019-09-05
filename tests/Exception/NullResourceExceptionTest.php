<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test\Exception;

use wiejakp\ImageCrop\Exception\NullResourceException;
use wiejakp\ImageCrop\Test\TestCase;

/**
 * @inheritDoc
 */
class NullResourceExceptionTest extends TestCase
{
    /**
     * @throws NullResourceException
     */
    public function testConstruct(): void
    {
        $this->expectException(NullResourceException::class);

        throw new NullResourceException();
    }
}
