<?php

class Atsumoriso_Blog_Model_Post extends Mage_Core_Model_Abstract
{
    const STATUS_POST_ACTIVE        = 1;
    const STATUS_POST_NOT_ACTIVE    = 2;

    /**
     * Url to list of all posts.
     */
    const POSTS_LIST_URL = '/blog/post/list';
    /**
     * Url for uploads folder
     */
    const UPLOADS_FOLDER_URL = 'uploads/';


    protected function _construct()
    {
        $this->_init('blog/post');
    }

    /**
     * Retrieve statuses array
     *
     * @return array
     */
    public static function getStatusesArray()
    {
        return array(
            self::STATUS_POST_ACTIVE      => Mage::helper('atsumoriso_blog')->__('Active'),
            self::STATUS_POST_NOT_ACTIVE  => Mage::helper('atsumoriso_blog')->__('Not active')
        );
    }

    /**
     * Gets collection of posts, sorted by parameter.
     * @param $sort
     * @param $direction
     * @return mixed
     */
    public function getListOfPostsAndAuthorsSortedByParam($sort, $direction)
    {
        $coll = Mage::getModel('blog/post')->getCollection()->setOrder($sort, $direction);

        $fn = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'firstname');
        $ln = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'lastname');

        $coll->getSelect()
            ->join(array('first_name' => 'customer_entity_varchar'), 'first_name.entity_id=main_table.`author_id`', array('firstname' => 'value'))
            ->where('first_name.attribute_id='.$fn->getAttributeId()
            )
            ->join(array('last_name' => 'customer_entity_varchar'), 'last_name.entity_id=main_table.`author_id`', array('lastname' => 'value'))
            ->where('last_name.attribute_id='.$ln->getAttributeId())
            ->columns(new Zend_Db_Expr("CONCAT(`first_name`.`value`, ' ',`last_name`.`value`) AS fullname")
            );

        return $coll->getData();
    }


    /**
     * Gets single post data.
     * @param $id
     * @return Mage_Core_Model_Abstract
     */
    public function getSinglePostData($id)
    {
        $post = Mage::getModel('blog/post')->load($id);
        return $post;
    }


    /**
     * Validates photo file and saves it to blog photo directory.
     * @return string
     */
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
                $uploader->setAllowedExtensions(array('jpg', 'png', 'jpeg'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $path = Mage::getBaseDir('media') . DS . Atsumoriso_Blog_Model_Post::UPLOADS_FOLDER_URL;
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $uploader->save($path . DS, $fileName);

                return Atsumoriso_Blog_Model_Post::UPLOADS_FOLDER_URL . $fileName;

            } catch (Exception $e) {
                Mage::getSingleton('customer/session')->addError($e->getMessage());
                $error = true;
            }
        }
    }

    /**
     *  Returns id parameter from GET query. //todo not available from controller
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
//    public function getCurrentBlogPost() //todo check usage and delete
//    {
//        //$params = $this->getRequest()->getParams();
//        $blogpost = Mage::getModel('blog/post');
////        $blogpost->load($params['id']);
//        $blogpost->load($this->getCurrentPostId());
//        return $blogpost;
//    }
//
//    public function getCurrentBlogPost1($id) //todo correct method
//    {
//        //$params = $this->getRequest()->getParams();
//        $blogpost = Mage::getModel('blog/post');
////        $blogpost->load($params['id']);
//        $blogpost->load($id);
//        return $blogpost;
//    }

}