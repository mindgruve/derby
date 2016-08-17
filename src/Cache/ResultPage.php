<?php

namespace Derby\Cache;

class ResultPage implements \Iterator
{

    /**
     * @var
     */
    protected $items;

    /**
     * @var
     */
    protected $limit;

    /**
     * @var
     */
    protected $continuationToken;

    /**
     * @param $items
     * @param $limit
     * @param $continuationToken
     */
    public function __construct(array $items, $limit, $continuationToken)
    {
        $this->items = $items;
        $this->limit = $limit;
        $this->continuationToken = $continuationToken;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param $items
     * @return $this
     */
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContinuationToken()
    {
        return $this->continuationToken;
    }

    /**
     * @param $continuationToken
     * @return $this
     */
    public function setContinuationToken($continuationToken)
    {
        $this->continuationToken = $continuationToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return next($this->items);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * @return mixed
     */
    public function valid()
    {
        return isset($this->items[key($this->items)]);
    }

    /**
     * @return mixed
     */
    public function rewind()
    {
        return prev($this->items);
    }


}