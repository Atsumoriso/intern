<?php

class Atsumoriso_Blog_Block_Posts extends Mage_Catalog_Block_Product
    //Mage_Core_Block_Template
{
    /**
     * Gets one record of post by id.
     * @return mixed
     */
    public function viewOnePost()
     {
         $params = $this->getRequest()->getParams();

         $model =  Mage::getModel('blog/post');
         return $model->getSinglePostData($params);
     }

    /**
     * Gets collection of posts with sorting order.
     * @return mixed
     */
    public function viewAllPosts()
     {
         $params = $this->getRequest()->getParams();
         if(isset($params['sort']) && isset($params['direction'])){
             if($params['sort'] == 'author'){
                 $sort = 'fullname';
             } elseif ($params['sort'] == 'date'){
                 $sort ='created_at';
             } else {
                 $sort ='created_at';
             }

             if($params['direction'] == 'asc'){
                 $direction = 'ASC';
             } else {
                 $direction = 'DESC';
             }
         } else {
             $sort      = 'created_at';
             $direction = 'DESC';
         }

         $model = Mage::getModel('blog/post');

         return $model->getListOfPostsAndAuthorsSortedByParam($sort, $direction);

     }


    /**
     * Gets binded products for the certain post.
     * @return mixed
     */
    public function getBindedProducts()
    {
        $params = $this->getRequest()->getParams();
        $model = Mage::getModel('blog/productbinded');
        return $model->getBindedProductByPostId($params['id']);
    }

}