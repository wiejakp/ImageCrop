<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WP\ImageCrop\Writer;

use WP\ImageCrop\Manager\WriterManager;

/**
 * Class AbstractWriter
 *
 * @package WP\ImageCrop\Writer
 */
abstract class AbstractWriter
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var WriterManager
     */
    protected $manager;

    /**
     * @var string|null
     */
    protected $source;

    /**
     * @var string|null
     */
    protected $destination;

    /**
     * @var false|resource|null
     */
    protected $resource;

    /**
     * AbstractWriter constructor.
     *
     * @param WriterManager $manager
     */
    public function __construct(WriterManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return self
     */
    public function setClass(string $class): self
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return WriterManager
     */
    public function getManager(): WriterManager
    {
        return $this->manager;
    }

    /**
     * @param WriterManager $manager
     * @return self
     */
    public function setManager(WriterManager $manager): self
    {
        $this->manager = $manager;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string|null $source
     * @return self
     */
    public function setSource(?string $source): self
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDestination(): ?string
    {
        return $this->destination;
    }

    /**
     * @param string|null $destination
     * @return self
     */
    public function setDestination(?string $destination): self
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @return false|resource|null
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param false|resource|null $resource
     * @return self
     */
    public function setResource($resource): self
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @return false|resource|null
     */
    public function createResource()
    {
        return null;
    }

    /**
     * @param string      $source
     * @param string|null $destination
     * @return void
     */
    public function load(string $source, ?string $destination = null): void {
        $this->source = $source;
        $this->resource = $this->createResource();

        if($destination) {
            $this->destination = $destination;
        }
        else {
            $this->destination = $this->manager->getTempFile($this->class);
        }
    }
}
