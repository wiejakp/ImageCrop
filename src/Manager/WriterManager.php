<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Manager;

use wiejakp\ImageCrop\Writer\AbstractWriter;

/**
 * Class WriterManager
 *
 * @package wiejakp\ImageCrop\Manager
 */
class WriterManager extends AbstractManager
{
    /**
     * @param string $class
     * @return AbstractWriter
     * @throws \Exception
     */
    public function getWriter(string $class): AbstractWriter
    {
        if (false === $this->isWriterClass($class)) {
            throw new \Exception(\sprintf('Provided writer was not found: %s', $class));
        }

        /**
         * create new writer object
         *
         * @var AbstractWriter $writer
         */
        $writer = new $class($this);

        return $writer;
    }

    /**
     * @param string $class
     * @return bool
     */
    private function isWriterClass(string $class): bool
    {
        return $this->isLibraryClass('Writer', $class);
    }
}
