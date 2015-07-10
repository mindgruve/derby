<?php

namespace Derby\Media\LocalFile;

use Imagine\Image\Box;
use Imagine\Image\Point;

class ImageTransformer
{

    /**
     * @var array
     */
    protected $identityTransform = array(
        array(
            'greyscale' => false,
            'flipVertically' => false,
            'flipHorizontally' => false,
            'rotate' => false,
            'crop' => false,
            'resize' => false,
        )
    );

    /**
     * @var array
     */
    protected $filters;

    protected $key;

    protected $adapter;


    public function __construct()
    {
        $this->filters = $this->identityTransform;
    }

    public function addFilter(array $filter = array())
    {
        $this->filters[] = $filter;
    }

    /**
     * @param Image $image
     * @return Image
     */
    public function apply(Image $image, $newKey, $newAdapter = null)
    {
        if (!$newAdapter) {
            $newAdapter = $image->getAdapter();
        }

        $newImage = new Image($newKey, $newAdapter, $image->getImagine());
        $newImage->write($image->read());

        foreach ($this->filters as $filter) {
            foreach ($filter as $action => $parameters) {
                if ($parameters) {
                    switch (strtolower(trim($action))) {
                        case 'greyscale':
                            $newImage = $this->greyscale($newImage, $newKey, $newAdapter);
                            break;
                        case 'flipvertically':
                            $newImage = $this->flipVertically($newImage, $newKey, $newAdapter);
                            break;
                        case 'fliphorizontally':
                            $newImage = $this->flipHorizontally($newImage, $newKey, $newAdapter);
                            break;
                        case 'resize':
                            $newImage = $this->resize($newImage, $newKey, $newAdapter, $parameters);
                            break;
                        case 'crop':
                            $newImage = $this->crop($newImage, $newKey, $newAdapter, $parameters);
                            break;
                        case 'rotate':
                            $newImage = $this->rotate($newImage, $newKey, $newAdapter, $parameters);
                            break;
                    }
                }
            }
        }
    }

    protected function greyscale(Image $image, $key, $adapter)
    {
        $image->greyscale($key, $adapter);

        return $image;
    }

    protected function flipVertically(Image $image, $key, $adapter)
    {
        $image->flipVertically($key, $adapter);

        return $image;
    }

    protected function flipHorizontally(Image $image, $key, $adapter)
    {
        $image->flipHorizontally($key, $adapter);

        return $image;
    }

    protected function resize(Image $image, $key, $adapter, $parameters)
    {
        $height = isset($parameters['height']) ? $parameters['height'] : 0;
        $width = isset($parameters['width']) ? $parameters['width'] : 0;
        $mode = isset($parameters['mode']) ? $parameters['mode'] : Image::DEFAULT_MODE;
        $quality = isset($parameters['quality']) ? $parameters['quality'] : Image::DEFAULT_QUALITY;
        $image->resize($key, $width, $height, $mode, $quality, $adapter);

        return $image;
    }

    public function crop(Image $image, $key, $adapter, $parameters)
    {
        $x = isset($parameters['x']) ? $parameters['x'] : 0;
        $y = isset($parameters['y']) ? $parameters['y'] : 0;
        $height = isset($parameters['height']) ? $parameters['height'] : 0;
        $width = isset($parameters['width']) ? $parameters['width'] : 0;
        $point = new Point($x, $y);
        $box = new Box($width, $height);
        $image->crop($key, $point, $box, $adapter);

        return $image;
    }

    public function rotate(Image $image, $key, $adapter, $parameters)
    {
        $degrees = isset($parameters['degrees']) ? $parameters['degrees'] : 0;
        $image->rotate($key, $degrees, $adapter);

        return $image;
    }


}