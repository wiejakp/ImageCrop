<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Manager;

use wiejakp\ImageCrop\Exception\NullWriterException;
use wiejakp\ImageCrop\ImageCrop;
use wiejakp\ImageCrop\Writer\AbstractWriter;
use wiejakp\ImageCrop\Writer\BMPWriter;
use wiejakp\ImageCrop\Writer\GIFWriter;
use wiejakp\ImageCrop\Writer\JPEGWriter;
use wiejakp\ImageCrop\Writer\PNGWriter;

/**
 * Class WriterManager
 */
class WriterManager extends AbstractManager
{
    /** @var string */
    const LIBRARY = 'Writer';

    /**
     * WriterManager constructor.
     *
     * @param ImageCrop $core
     */
    public function __construct(ImageCrop $core)
    {
        parent::__construct($core);

        $this->writers = $this->getManagerLibraries(self::LIBRARY);
    }

    /**
     * @return AbstractWriter|BMPWriter|GIFWriter|JPEGWriter|PNGWriter
     *
     * @throws NullWriterException
     */
    public function getWriter(): AbstractWriter
    {
        if (null === $this->writer) {
            throw new NullWriterException();
        }

        return $this->writer;
    }

    /**
     * @param string $class
     *
     * @return self
     */
    public function setWriter(string $class): self
    {
        $this->writer = $this->getWriters()[$class];

        return $this;
    }

    /**
     * @return AbstractWriter[]
     */
    public function getWriters(): array
    {
        return $this->writers;
    }
}
