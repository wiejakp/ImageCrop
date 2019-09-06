<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Manager;

use DataURI\Data;
use DataURI\Dumper;
use wiejakp\ImageCrop\Exception\NullReaderException;
use wiejakp\ImageCrop\Exception\NullWriterException;
use wiejakp\ImageCrop\Exception\ReaderNotFoundException;
use wiejakp\ImageCrop\Exception\WriterNotFoundException;
use wiejakp\ImageCrop\ImageCrop;
use wiejakp\ImageCrop\Reader\AbstractReader;
use wiejakp\ImageCrop\Reader\BMPReader;
use wiejakp\ImageCrop\Reader\GIFReader;
use wiejakp\ImageCrop\Reader\JPEGReader;
use wiejakp\ImageCrop\Reader\PNGReader;
use wiejakp\ImageCrop\Writer\AbstractWriter;
use wiejakp\ImageCrop\Writer\BMPWriter;
use wiejakp\ImageCrop\Writer\GIFWriter;
use wiejakp\ImageCrop\Writer\JPEGWriter;
use wiejakp\ImageCrop\Writer\PNGWriter;

/**
 * Class AbstractManager
 */
abstract class AbstractManager
{
    /**
     * @var ImageCrop
     */
    protected $core;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var AbstractReader|BMPReader|GIFReader|JPEGReader|PNGReader
     */
    protected $reader;

    /**
     * @var AbstractWriter|BMPWriter|GIFWriter|JPEGWriter|PNGWriter
     */
    private $writer;

    /**
     * AbstractManager constructor.
     *
     * @param ImageCrop $core
     */
    public function __construct(ImageCrop $core)
    {
        $this->core = $core;
        $this->namespace = (new \ReflectionClass(ImageCrop::class))->getNamespaceName();
    }

    /**
     * @return ImageCrop
     */
    public function getCore(): ImageCrop
    {
        return $this->core;
    }

    /**
     * @param string $class
     *
     * @return AbstractReader
     *
     * @throws \Exception
     */
    public function findReader(string $class): AbstractReader
    {
        if (false === $this->isReaderClass($class)) {
            throw new ReaderNotFoundException(\sprintf('Provided reader was not found: %s', $class));
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
     * @param string|BMPReader|GIFReader|JPEGReader|PNGReader $reader
     *
     * @return self
     *
     * @throws \Exception
     */
    public function setReader($reader): self
    {
        switch (true) {
            case \is_string($reader):
                $this->reader = $this->findReader($reader);
                break;

            case \is_subclass_of($reader, AbstractReader::class):
                $this->reader = $reader;
                break;

            default:
                throw new \Exception('Suggested Reader is not supported.');
        }

        return $this;
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function isReaderClass(string $class): bool
    {
        return $this->isLibraryClass('Reader', $class);
    }


    /**
     * @param string $class
     *
     * @return AbstractWriter
     *
     * @throws \Exception
     */
    public function findWriter(string $class): AbstractWriter
    {
        if (false === $this->isWriterClass($class)) {
            throw new WriterNotFoundException(\sprintf('Provided writer was not found: %s', $class));
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
     * @param string|BMPWriter|GIFWriter|JPEGWriter|PNGWriter $writer
     *
     * @return self
     *
     * @throws \Exception
     */
    public function setWriter($writer): self
    {
        switch (true) {
            case \is_string($writer):
                $this->writer = $this->findWriter($writer);
                break;

            case \is_subclass_of($writer, AbstractWriter::class):
                $this->writer = $writer;
                break;

            default:
                throw new \Exception('Suggested Writer is not supported.');
        }

        return $this;
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
     * @return bool
     */
    public function isWriterClass(string $class): bool
    {
        return $this->isLibraryClass('Writer', $class);
    }

    /**
     * @param string|null $class
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getTempFile(?string $class = null): string
    {
        if (null === $class) {
            $class = \get_class($this);
        }

        $path = \tempnam(\sys_get_temp_dir(), \sprintf('%s_', $this->getShortName($class)));

        if (false === $path) {
            throw new \Exception('Unable to fetch a temporary file.');
        }

        return $path;
    }

    /**
     * @param string $class
     *
     * @return string|null
     */
    public function getShortName(string $class): ?string
    {
        $array = \explode('\\', $class);

        return \array_pop($array);
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    public function getData(string $path): ?string
    {
        $data = \file_get_contents($path);

        return $data ? $data : null;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getDataUri(string $path): string
    {
        $content = $this->getData($path) ?? '';
        $uri = new Data($content, $this->getDataMimeType($path));

        return Dumper::dump($uri);
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    public function getDataMimeType(string $path): ?string
    {
        $mimeType = \mime_content_type($path);

        return $mimeType ? $mimeType : null;
    }

    /**
     * @param string $library
     * @param string $class
     *
     * @return bool
     */
    protected function isLibraryClass(string $library, string $class): bool
    {
        $namespace = \sprintf('%s\\%s\\', $this->namespace, $library);
        $length = \strlen($namespace);

        return \substr($class, 0, $length) === $namespace && \class_exists($class);
    }
}
