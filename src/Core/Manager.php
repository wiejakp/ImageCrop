<?php
/**
 * (c) Przemek Wiejak <przmek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WP\ImageCrop\Core;

/**
 * Class ReaderManager
 *
 * @package WP\ImageCrop\Core
 */
class Manager
{
    /**
     * @var string
     */
    private $root;

    /**
     * Manager constructor.
     *
     * @param string $root
     */
    public function __construct(string $root) {

    }

    /**
     * @return string
     */
    public function getRoot(): string
    {
        return $this->root;
    }

    /**
     * @return string
     */
    public function getCore(): string
    {
        return $this->root;
    }

    /**
     * @return string
     */
    public function getReader(): string
    {
        return $this->reader;
    }
}
