<?php

class Atsumoriso_Blog_Model_Post extends Mage_Core_Model_Abstract
{
    /**
     * Url to list of all posts.
     */
    const POSTS_LIST_URL = '/blog/post/list';
    /**
     * Url for photo folder (used for deleting files).
     */
    const BLOG_PHOTO_FOLDER_URL = MAGENTO_ROOT . '/media/uploads/';
    /**
     * Web url for photo folder.
     */
    const BLOG_PHOTO_FOLDER_WEB_URL = '';

    protected function _construct()
    {
        $this->_init('blog/post');
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
     * @param $post
     * @return stdClass
     */
    public function getSinglePostData($params)
    {
        $post = Mage::getModel('blog/post')->load($params['id']);
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