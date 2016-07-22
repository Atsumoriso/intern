<?php

namespace components;

/**
 * Class Paginator.
 * Class for creating pagination for big lists of data.
 *
 * @package components
 */
class Paginator
{
    /**
     * total quantity of items
     * @var
     */
    protected $_count;

    /**
     * Quantity of items on 1 page.
     * @var
     */
    protected $_itemsPerPage;

    /**
     * Quantity of pages.
     * @var float
     */
    protected $_pagesQuantity;

    /**
     * Number of current page.
     * @var
     */
    protected $_currentPage;

    /**
     * Default quantity of items on 1 page.
     */
    const ITEMS_PER_PAGE = 10;

    public function __construct($count,$itemsPerPage = null)
    {
        $this->_count          = $count;
        if($itemsPerPage == null){
            $this->_itemsPerPage   = self::ITEMS_PER_PAGE;
        } else {
            $this->_itemsPerPage   = $itemsPerPage;
        }
        $this->_pagesQuantity  = ceil($this->_count/$this->_itemsPerPage);
    }

    /**
     * @return mixed
     */
    public function getItemsPerPage()
    {
        return $this->_itemsPerPage;
    }

    /**
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->_currentPage;
    }

    /**
     * @param mixed $currentPage
     */
    public function setCurrentPage($currentPage)
    {
        $this->_currentPage = $currentPage;
    }


    public function run($sort,$direction)
    {
        return $this->_getPagination($sort,$direction);
    }

    protected function _getPagination($sort,$direction)
    {
        if($this->_pagesQuantity > 1){
            echo '<ul class="pagination pagination-lg">';
            for ($i = 1; $i<=$this->_pagesQuantity; $i++){
                echo '<li';
                if(isset($this->_currentPage) && $this->_currentPage == $i)
                    echo ' class="active"';
                echo '>';
                echo '<a href="';
                echo SITE_URL . '/dashboard/list?sort=' . $sort . '&direction=' . $direction . '&page=';
                echo $i;
                echo '">';
                echo $i;
                echo '</a>';
                echo '</li>';
            }

            echo '</ul>';
            echo '<p>';
            echo "Totally $this->_count items on $this->_pagesQuantity pages";
            echo '</p>';
        }


    }

}