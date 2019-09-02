<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Test;

use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * Class TestCase
 */
class TestCase extends MockeryTestCase
{
    /**
     * @var string
     */
    private $root;

    /**
     * TestCase constructor.
     *
     * @param null   $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->root = \explode('/', \dirname(__FILE__), 1)[0];
    }

    /**
     * @return string
     */
    protected function getRootPath(): string
    {
        return $this->root;
    }

    /**
     * @return string
     */
    protected function getPixelsPath(): string
    {
        return \sprintf('%s%s', $this->getRootPath(), '/pixels');
    }
}
