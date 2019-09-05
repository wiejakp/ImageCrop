<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test\Exception;

use wiejakp\ImageCrop\Exception\DoNotCallDirectlyException;
use wiejakp\ImageCrop\Test\TestCase;

/**
 * @inheritDoc
 */
class DoNotCallDirectlyExceptionTest extends TestCase
{
    /**
     * @throws DoNotCallDirectlyException
     */
    public function testConstruct(): void
    {
        $this->expectException(DoNotCallDirectlyException::class);

        throw new DoNotCallDirectlyException();
    }
}
