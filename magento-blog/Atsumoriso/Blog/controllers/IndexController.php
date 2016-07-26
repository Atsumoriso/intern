<?php

class Atsumoriso_Blog_IndexController extends Mage_Core_Controller_Front_Action
{

    /**
     * Redirect to blog
     *
     * @return void
     */
    public function indexAction()
    {
        Mage::app()->getFrontController()->getResponse()->setRedirect(Atsumoriso_Blog_Model_Post::POSTS_LIST_URL);
    }
}