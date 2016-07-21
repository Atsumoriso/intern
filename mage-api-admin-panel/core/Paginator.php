<?php

namespace core;

/**
 * Class Paginator.
 * Class for creating pagination for big lists of data.
 *
 * @package core
 */
class Paginator
{
    public $count;

    public $itemsPerPage;

    public $pagesQuantity;

    const ITEMS_PER_PAGE = 10;

    public function __construct($count,$itemsPerPage)
    {
        $this->count          = $count;
        $this->itemsPerPage   = $itemsPerPage;
        $this->pagesQuantity  = ceil($count/$itemsPerPage);
    }
}