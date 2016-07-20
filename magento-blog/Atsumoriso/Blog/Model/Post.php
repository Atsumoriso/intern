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
     * Gets collection of posts, sorted by parameter
     *
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
            ->join(array('ce1' => 'customer_entity_varchar'), 'ce1.entity_id=main_table.`author_id`', array('firstname' => 'value'))
            ->where('ce1.attribute_id='.$fn->getAttributeId())
            ->join(array('ce2' => 'customer_entity_varchar'), 'ce2.entity_id=main_table.`author_id`', array('lastname' => 'value'))
            ->where('ce2.attribute_id='.$ln->getAttributeId())
            ->columns(new Zend_Db_Expr("CONCAT(`ce1`.`value`, ' ',`ce2`.`value`) AS fullname"));

        return $coll->getData();
    }



    /**
     * Gets single post data
     *
     * @param $post
     * @return stdClass
     */
    public function getSinglePostData($params)
    {
        $blogpost = Mage::getModel('blog/post');
        $post = $blogpost->load($params['id']);

         $postObj = new stdClass();
         $postObj->post_id      = $post->getPostId();
         $postObj->headline     = $post->getHeadline();
         $postObj->text         = $post->getText();
         $postObj->created_at   = $post->getCreatedAt();
         $postObj->language_id  = $post->getLanguageId();
         $postObj->author_id    = $post->getAuthorId();
         $postObj->photo_path   = $post->getPhotoPath();

         return $postObj;
    }

}