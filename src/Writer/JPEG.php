<?php
/**
 * (c) Przemek Wiejak <przemek@wiejak.app>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace wiejakp\ImageCrop\Reader;

use wiejakp\ImageCrop\Manager\ReaderManager;

/**
 * Class JPEG
 *
 * @package wiejakp\ImageCrop\Reader
 */
class JPEG extends AbstractReader
{
    /**
     * JPEG constructor.
     *
     * @param ReaderManager $manager
     */
    public function __construct(ReaderManager $manager)
    {
        parent::__construct($manager);

        $this->class = \get_class($this);
    }

    /**
     * @return false|resource|null
     * @throws \Exception
     */
    public function createResource()
    {
        $resource = null;

        try {
            $resource = \imagecreatefromjpeg($this->source);
        } catch (\Exception $exception) {
            throw new \Exception(
                \sprintf(
                    'Provided file is not compatible with %s reader.',
                    $this->getManager()->getShortName()
                )
            );
        }

        return $resource;
    }
}