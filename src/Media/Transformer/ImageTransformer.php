<?php

namespace Derby\Media\Transformer;

use Derby\Media\File\Image;
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
     * @return Image
     */
    public function apply($filterKey, Image $image, $resolution = 1)
    {
        if (!isset($this->filters[$filterKey])) {
            return $image;
        }

        $filter = $this->filters[$filterKey];
        $resolution = (float) $resolution;

        foreach ($filter as $action => $parameters) {
            if ($parameters) {
                switch (strtolower(trim($action))) {
                    case 'greyscale':
                        $image = $this->greyscale($image);
                        break;
                    case 'flipvertically':
                        $image = $this->flipVertically($image);
                        break;
                    case 'fliphorizontally':
                        $image = $this->flipHorizontally($image);
                        break;
                    case 'resize':

                        if($resolution && isset($parameters['width'])){
                            $parameters['width'] = $resolution * $parameters['width'];
                        }
                        if($resolution && isset($parameters['height'])){
                            $parameters['width'] = $resolution * $parameters['height'];
                        }

                        $image = $this->resize($image, $parameters);
                        break;
                    case 'crop':
                        $image = $this->crop($image, $parameters);
                        break;
                    case 'rotate':
                        $image = $this->rotate($image, $parameters);
                        break;
                }
            }
        }

        return $image;
    }

    protected function greyscale(Image $image)
    {
        $image->greyscale();

        return $image;
    }

    protected function flipVertically(Image $image)
    {
        $image->flipVertically();

        return $image;
    }

    protected function flipHorizontally(Image $image)
    {
        $image->flipHorizontally();

        return $image;
    }

    protected function resize(Image $image, $parameters)
    {
        $height = isset($parameters['height']) ? $parameters['height'] : 0;
        $width = isset($parameters['width']) ? $parameters['width'] : 0;
        $mode = isset($parameters['mode']) ? $parameters['mode'] : Image::DEFAULT_MODE;
        $image->resize($width, $height, $mode);

        return $image;
    }

    public function crop(Image $image, $parameters)
    {
        $x = isset($parameters['x']) ? $parameters['x'] : 0;
        $y = isset($parameters['y']) ? $parameters['y'] : 0;
        $height = isset($parameters['height']) ? $parameters['height'] : 0;
        $width = isset($parameters['width']) ? $parameters['width'] : 0;
        $image->crop($x, $y, $height, $width);

        return $image;
    }

    public function rotate(Image $image, $parameters)
    {
        $degrees = isset($parameters['degrees']) ? $parameters['degrees'] : 0;
        $image->rotate($degrees);

        return $image;
    }
}