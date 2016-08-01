<?php

class Atsumoriso_Blog_Block_Adminhtml_Blog_Post extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'atsumoriso_blog';
        $this->_controller = 'adminhtml_blog_post'; //block path inside Block folder
        $this->_headerText = Mage::helper('atsumoriso_blog')->__('Blog posts');

        parent::__construct();
//        $this->_removeButton('add');
//        $this->_addButton('add');
    }
}