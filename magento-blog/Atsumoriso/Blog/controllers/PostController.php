<?php

class Atsumoriso_Blog_PostController extends Mage_Core_Controller_Front_Action
{

    /**
     * Displays one record.
     *
     * @return void
     */
    public function viewAction()
    {
        if(empty($this->getCurrentPostId())){
            Mage::app()->getFrontController()->getResponse()->setRedirect(Atsumoriso_Blog_Model_Post::POSTS_LIST_URL);
        }

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Post #' . $this->getCurrentPostId()));
        $this->renderLayout();
    }

    /**
     * Displays list of posts
     *
     * @return void
     */
    public function listAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Edits one record, if this record belongs to this logged-in-user.
     *
     * @return void
     */
    public function editAction()
    {
        if(!Mage::getSingleton('customer/session')->isLoggedIn()){
            Mage::app()->getFrontController()->getResponse()->setRedirect(Atsumoriso_Blog_Model_Post::POSTS_LIST_URL);
        }

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Edit post #' . $this->getCurrentPostId()));
        $this->renderLayout();

        $post = $this->getRequest()->getPost();
        if(!empty($post)){
            //validate and save photo
            $model = new Atsumoriso_Blog_Model_Post();

            $fileName = $model->validateAndSavePhoto();
            $blogpost = $this->getCurrentBlogPost();

            $blogpost->setHeadline($post['title']);
            $blogpost->setText($post['text']);
            if($fileName != ''){
                $oldFileName = $blogpost->getPhotoPath();
                unlink(Atsumoriso_Blog_Model_Post::BLOG_PHOTO_FOLDER_URL  . $oldFileName);
                $blogpost->setPhotoPath($fileName);
            }
            $blogpost->save();
            Mage::app()->getFrontController()->getResponse()->setRedirect(Atsumoriso_Blog_Model_Post::POSTS_LIST_URL);
        }
    }

    /**
     * Adds new record, allowed for logged-in-users only.
     *
     * @return void
     */
    public function addAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Add new post'));
        $this->renderLayout();

        $post = $this->getRequest()->getPost();
        if(!empty($post)){
            $model = new Atsumoriso_Blog_Model_Post();
            $fileName = $model->validateAndSavePhoto();
            $blogpost = Mage::getModel('blog/post');
            $blogpost->setHeadline($post['title']);
            if($fileName != ''){
                $blogpost->setPhotoPath($fileName);
            }
            $blogpost->setText($post['text']);
            $blogpost->setAuthorId(Mage::getSingleton('customer/session')->getCustomer()->getId());
            $blogpost->save();
            Mage::app()->getFrontController()->getResponse()->setRedirect(Atsumoriso_Blog_Model_Post::POSTS_LIST_URL);
        }


    }

    /**
     * Deletes one record, if this record belongs to this logged-in-user.
     *
     * @return void
     */
    public function deleteAction()
    {
        $post = $this->getRequest()->getPost('delete');

        if(isset($post) && $post == $this->getCurrentPostId()) {
            $blogpost = $this->getCurrentBlogPost();
            $oldFileName = $blogpost->getPhotoPath();
            unlink(Atsumoriso_Blog_Model_Post::BLOG_PHOTO_FOLDER_URL  . $oldFileName);
            $blogpost->delete();
        }

        Mage::app()->getFrontController()->getResponse()->setRedirect(Atsumoriso_Blog_Model_Post::POSTS_LIST_URL);
    }





    /**
     *  Returns id parameter from GET query.
     *
     * @return mixed
     */
    public function getCurrentPostId()
    {
        $params = $this->getRequest()->getParams();
        return $params['id'];
    }

    /**
     * Gets current post data
     *
     * @return false|Mage_Core_Model_Abstract
     */
    public function getCurrentBlogPost()
    {
        $params = $this->getRequest()->getParams();
        $blogpost = Mage::getModel('blog/post');
        $blogpost->load($params['id']);
        return $blogpost;
    }

}
