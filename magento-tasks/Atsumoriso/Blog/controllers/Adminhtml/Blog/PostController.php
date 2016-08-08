<?php


class Atsumoriso_Blog_Adminhtml_Blog_PostController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Blog'))->_title($this->__('Posts'));
        $this->loadLayout();
        $this->_setActiveMenu('atsumoriso_blog');
        $this->_addContent($this->getLayout()->createBlock('atsumoriso_blog/adminhtml_blog_post'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('atsumoriso_blog/adminhtml_blog_post_grid')->toHtml()
        );
    }

    public function exportInchooCsvAction()
    {
        $fileName = 'blog_posts.csv';
        $grid = $this->getLayout()->createBlock('atsumoriso_blog/adminhtml_blog_post_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    public function exportInchooExcelAction()
    {
        $fileName = 'blog_posts.xml';
        $grid = $this->getLayout()->createBlock('atsumoriso_blog/adminhtml_blog_post_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    public function editAction()
    {
        $params = $this->getRequest()->getParams();

        $this->_title($this->__('Blog'))->_title($this->__('Edit post #' . $params['id']));
        $this->loadLayout();
        $this->_setActiveMenu('atsumoriso_blog');
        $this->_addContent($this->getLayout()->createBlock('atsumoriso_blog/adminhtml_blog_edit'));

        $model =  new Atsumoriso_Blog_Model_Post();
        $post = $model->getSinglePostData($params['id']);
        Mage::register('post', $post);

        $this->renderLayout();
    }

    public function formAction()
    {

    }

    public function newAction()
    {
        $this->_forward('edit');
//        $post = $this->getRequest()->getPost();
//        if()
//        $this->_forward('save');
//        var_dump($post);
    }

    /**
     * Deletes record.
     */
    public function deleteAction()
    {
        $params = $this->getRequest()->getParams();
        $model = new Atsumoriso_Blog_Model_Post();
        //get post data
        $blogpost = $model->getSinglePostData($params['id']);
        //deleting post photo
        $oldFileName = $blogpost->getPhotoPath();
        unlink(Mage::getBaseDir('media')  . DS .$oldFileName);
        //deleting record
        $blogpost->delete();

        //forward to blog list index page
        $this->_forward('index');
    }

    /**
     * Saves record to DB.
     */
    public function saveAction()
    {
        //get data
        $params = $this->getRequest()->getParams();
        $model = new Atsumoriso_Blog_Model_Post();
//        var_dump($model);
        $post = $this->getRequest()->getPost();
//
//        var_dump($params);
//        exit;

        if(isset($params['id']) && empty($params['back'])) {
            $blogpost = $model->getSinglePostData($params['id']);

            //get filename
            $fileName = $model->validateAndSavePhoto();
            //set data
            $blogpost->setHeadline($post['headline']);
            $blogpost->setText($post['text']);
            //if checkbox, deleting old file
            if ($post['attachment']['delete'] == 1) {
                $oldFileName = $blogpost->getPhotoPath();
                unlink(Mage::getBaseDir('media') . $oldFileName);
            }
            $blogpost->setPhotoPath($fileName);
            $blogpost->save();
            $this->_forward('index');

        } elseif (isset($params['id']) && $params['back'] == 'edit') {
            $blogpost = $model->getSinglePostData($params['id']);

            //get filename
            $fileName = $model->validateAndSavePhoto();
            //set data
            $blogpost->setHeadline($post['headline']);
            $blogpost->setText($post['text']);
            //if checkbox, deleting old file
            if ($post['attachment']['delete'] == 1) {
                $oldFileName = $blogpost->getPhotoPath();
                unlink(Mage::getBaseDir('media') . $oldFileName);
            }
            $blogpost->setPhotoPath($fileName);
            $blogpost->save();
            $this->_forward('edit');

        } else {
            $new = Mage::getModel('blog/post');
            $new->setHeadline($post['headline']);
            $new->setText($post['text']);
            $fileName = $model->validateAndSavePhoto();
            if($fileName != ''){
                $new->setPhotoPath($fileName);
            }
            $new->setAuthorId(138); //todo Mage::getSingleton('admin/session')->getUser()->getUserId()
            $new->save();
            $this->_forward('index');
        }

    }

    public function massDeleteAction()
    {
        $deletePostId = $this->getRequest()->getParam('post_to_delete');      // $this->getMassactionBlock()->setFormFieldName('tax_id'); from Mage_Adminhtml_Block_Tax_Rate_Grid
        if(!is_array($deletePostId)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('atsumoriso_blog')->__('Please select posts.'));
        } else {
            try {
                $model = Mage::getModel('blog/post');
                foreach ($deletePostId as $postId) {
                    $model->load($postId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('atsumoriso_blog')->__(
                        'Total of %d record(s) were deleted.', count($deletePostId)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

    public function massStatusAction()
    {
        //Mage_Adminhtml_Block_Catalog_Product_Grid

        $changeStatusPostId = $this->getRequest()->getParam('post_to_delete');

        $status = (int)$this->getRequest()->getParam('status');
       // var_dump($this->getRequest()->getParams());exit;

        if(!is_array($changeStatusPostId)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('atsumoriso_blog')->__('Please select posts.'));
        } else {
            try {
                $model = Mage::getModel('blog/post');
                foreach ($changeStatusPostId as $postId) {
                    $model->load($postId);
                    $model->setIsActive($status);
                    $model->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('atsumoriso_blog')->__(
                        'Totally %d record(s) have been updated.', count($changeStatusPostId)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }



}