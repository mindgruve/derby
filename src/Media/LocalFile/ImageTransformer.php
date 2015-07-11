<?php

namespace Derby\Media\LocalFile;

use Derby\Adapter\LocalFileAdapterInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;

class ImageTransformer
{
    /**
     * @var array
     */
    protected $filters;

    protected $adapter;


    /**
     * @param array $filters
     */
    public function __construct(array $filters = array())
    {
        foreach ($filters as $filterKey => $filter) {
            $this->addFilter($filterKey, $filter);
        }
    }

    /**
     * @param array $filters
     */
    public function addFilters(array $filters = array())
    {
        foreach ($filters as $filterKey => $filter) {
            $this->addFilter($filterKey, $filter);
        }
    }

    /**
     * @param $filterKey
     * @param array $filter
     */
    public function addFilter($filterKey, array $filter = array())
    {
        $this->filters[$filterKey] = $filter;
    }

    /**
     * @param $filterKey
     * @return bool
     */
    public function hasFilter($filterKey)
    {
        if (isset($this->filters[$filterKey])) {
            return true;
        }

        return false;
    }

    /**
     * @param $filterKey
     */
    public function removeFilter($filterKey)
    {
        if ($this->hasFilter($filterKey)) {
            unset($this->filters[$filterKey]);
        }
    }

    /**
     * @param $filterKey
     * @param Image $image
     * @param $newKey
     * @param LocalFileAdapterInterface $newAdapter
     * @return Image
     */
    public function apply($filterKey, Image $image, $newKey, LocalFileAdapterInterface $newAdapter)
    {
        if (!isset($this->filters[$filterKey])) {
            return $image;
        }

        $filter = $this->filters[$filterKey];
        $newImage = new Image($newKey, $newAdapter, $image->getImagine());
        $newImage->write($image->read());

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

        return $newImage;
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
        $image->resize($key, $adapter, $width, $height, $mode, $quality);

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
        $image->crop($key, $adapter, $point, $box);

        return $image;
    }

    public function rotate(Image $image, $key, $adapter, $parameters)
    {
        $degrees = isset($parameters['degrees']) ? $parameters['degrees'] : 0;
        $image->rotate($key, $adapter, $degrees);

        return $image;
    }


}