<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Manager;

use wiejakp\ImageCrop\Exception\NullReaderException;
use wiejakp\ImageCrop\ImageCrop;
use wiejakp\ImageCrop\Reader\AbstractReader;
use wiejakp\ImageCrop\Reader\BMPReader;
use wiejakp\ImageCrop\Reader\GIFReader;
use wiejakp\ImageCrop\Reader\JPEGReader;
use wiejakp\ImageCrop\Reader\PNGReader;

/**
 * Class ReaderManager
 */
class ReaderManager extends AbstractManager
{
    /** @var string */
    const LIBRARY = 'Reader';

    /**
     * ReaderManager constructor.
     *
     * @param ImageCrop $core
     */
    public function __construct(ImageCrop $core)
    {
        parent::__construct($core);

        $this->readers = $this->getManagerLibraries(self::LIBRARY);
    }

    /**
     * @return AbstractReader|BMPReader|GIFReader|JPEGReader|PNGReader
     *
     * @throws NullReaderException
     */
    public function getReader(): AbstractReader
    {
        if (null === $this->reader) {
            throw new NullReaderException();
        }

        return $this->reader;
    }

    /**
     * @param string $class
     *
     * @return AbstractManager
     */
    public function setReader(string $class): self
    {
        $this->reader = $this->getReaders()[$class];

        return $this;
    }

    /**
     * @return AbstractReader[]
     */
    public function getReaders(): array
    {
        return $this->readers;
    }
}
