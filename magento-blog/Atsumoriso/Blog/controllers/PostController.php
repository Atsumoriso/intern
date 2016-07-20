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
            $fileName = $this->validateAndSavePhoto();
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
            $fileName = $this->validateAndSavePhoto();
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
     *  Returnes id parameter from GET query.
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

    public function validateAndSavePhoto()
    {
        $fileName = '';
        if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != '') {
            try {
                $fileName = $_FILES['attachment']['name'];
                $fileExt = strtolower(substr(strrchr($fileName, "."), 1));
                $fileNamewoe = rtrim($fileName, $fileExt);
                $fileName = preg_replace('/\s+', '', $fileNamewoe) . time() . '.' . $fileExt;

                $uploader = new Varien_File_Uploader('attachment');
                $uploader->setAllowedExtensions(array('jpg', 'png', 'jpeg')); //add more file types you want to allow
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $path = Mage::getBaseDir('media') . '/uploads';
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $uploader->save($path . DS, $fileName);

                return $fileName;

            } catch (Exception $e) {
                Mage::getSingleton('customer/session')->addError($e->getMessage());
                $error = true;
            }
        }
    }
}
