<?php

/** 
 * @author rpsimao
 * 
 * 
 */
class App_Service_Paginator_Tables
{
    /**
     * 
     * Enter description here ...
     * @param $factory
     * @param $items
     * @param $page
     */
    function __construct ($factory, $items, $page)
    {

        $this->factory = $factory;
        $this->items = $items;
        $this->page = $page;
    }

    public function paginate ()
    {

        $paginator = Zend_Paginator::factory($this->factory);
        $paginator->setItemCountPerPage($this->items);
        $paginator->setCurrentPageNumber($this->page);
        return $paginator;
    }
}
?>