<?php

declare(strict_types=1);

namespace Alan6k8\CreditOne\Value;

use Countable;
use Iterator;

/**
 * I've borrowed this class from previous project, but it was written solely by me - I admit this for the sake of fair
 * play.
 */
abstract class AbstractCollection implements Iterator, Countable
{
    /**
     * @param mixed[] $items
     */
    public function __construct(
        public array $items
    ) {
        $this->items = $items;
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function isNotEmpty(): bool
    {
        return $this->count() !== 0;
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function current(): mixed
    {
        return current($this->items);
    }

    public function key(): mixed
    {
        return key($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    public function valid(): bool
    {
        return key($this->items) !== null;
    }

    public function count(): int
    {
        return count($this->items);
    }
}