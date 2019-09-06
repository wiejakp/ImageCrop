<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Exception;

/**
 * Class NullWriterException
 */
class NullWriterException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'Writer was never set.';
}
