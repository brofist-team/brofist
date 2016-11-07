<?php

namespace Brofist\Collection;

use Countable;
use Iterator;

class Collection implements Iterator, Countable
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @var string
     */
    private $itemInterface;

    public function __construct(string $itemInterface, array $items = [])
    {
        $this->itemInterface = $itemInterface;

        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function current()
    {
        return current($this->items);
    }

    public function next()
    {
        return next($this->items);
    }

    public function valid()
    {
        return isset($this->items[$this->key()]);
    }

    public function key()
    {
        return key($this->items);
    }

    public function rewind()
    {
        reset($this->items);
    }

    public function count()
    {
        return count($this->items);
    }

    public function getItemInterface() : string
    {
        return $this->itemInterface;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function add($item) : Collection
    {
        $this->validateType($item);

        $this->items[] = $item;
        return $this;
    }

    public function remove($itemToRemove) : Collection
    {
        foreach ($this->items as $i => $item) {
            if ($item === $itemToRemove) {
                unset($this->items[$i]);
            }
        }

        return $this;
    }

    public function toArray() : array
    {
        return $this->items;
    }

    protected function validateType($item)
    {
        $interface = $this->getItemInterface();

        if ($item instanceof $interface) {
            return;
        }

        throw new \InvalidArgumentException(
            sprintf('Item must implement "%s"', $this->getItemInterface())
        );
    }
}
