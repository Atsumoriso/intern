<?php

class Atsumoriso_Blog_Block_Posts extends Mage_Core_Block_Template
{
     public function viewOnePost()
     {
         $params = $this->getRequest()->getParams();

         $model =  Mage::getModel('blog/post');
         return $model->getSinglePostData($params);

     }

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


}