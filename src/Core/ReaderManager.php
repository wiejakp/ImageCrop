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
 class ReaderManager
{
    /**
     * @var string|null
     */
    protected $pathSource;

    /**
     * @var string|null
     */
    protected $pathDestination;

    /**
     * @var resource|null
     */
    protected $resource;

    /**
     * AbstractReader constructor.
     *
     * @param string $pathSource
     */
    public function __construct(string $pathSource)
    {
        $this->pathSource = $pathSource;
        $this->pathDestination = $this->createTempFile();
    }

    /**
     * get path to new temporary file
     *
     * @return string
     */
    protected function createTempFile(): string
    {
        return \tempnam(\sys_get_temp_dir(), \sprintf('%s_', $this->getShortName()));
    }

    /**
     * get short name of current class
     *
     * @return string
     */
    protected function getShortName(): string
    {
        return \array_pop(\explode('\\', __CLASS__));
    }
}
