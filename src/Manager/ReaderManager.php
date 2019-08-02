<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WP\ImageCrop\Manager;

use WP\ImageCrop\Reader\AbstractReader;

/**
 * Class ReaderManager
 *
 * @package WP\ImageCrop\Manager
 */
class ReaderManager extends AbstractManager
{
    /**
     * @param string $class
     * @return AbstractReader
     * @throws \Exception
     */
    public function getReader(string $class): AbstractReader
    {
        if (false === $this->isReaderClass($class)) {
            throw new \Exception(\sprintf('Provided reader was not found: %s', $class));
        }

        /**
         * create new reader object
         *
         * @var AbstractReader $reader
         */
        $reader = new $class($this);

        return $reader;
    }

    /**
     * @param string $class
     * @return bool
     */
    private function isReaderClass(string $class): bool
    {
        return $this->isLibraryClass('Reader', $class);
    }
}
