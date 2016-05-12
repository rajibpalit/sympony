<?php

namespace ArcaSolutions\ImageBundle\Services;

use ArcaSolutions\ImageBundle\Entity\Image;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageHandler
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Standard format for image name
     * @var string
     */
    private $imageName = '%sphoto_%d.%s';

    /**
     * @param ContainerInterface $container
     */
    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Alias for create the image name
     * @param Image $image
     * @return string
     */
    public function getPath($image)
    {
        $return = null;

        if($image){
            $prefix = $image->getPrefix();
            $id = $image->getId();
            $type = strtolower($image->getType());

            $return = sprintf($this->imageName, $prefix, $id, $type);
        }

        return $return;
    }
}
