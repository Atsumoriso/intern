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

    public function getOnePost($params)
    {
        $params = $this->getRequest()->getParams();
        $coll = Mage::getModel('blog/post')->getCollection();

        $fn = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'firstname');
        $ln = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'lastname');

        $coll->getSelect()
            ->join(array('ce1' => 'customer_entity_varchar'), 'ce1.entity_id=main_table.`author_id`', array('firstname' => 'value'))
            ->where('ce1.attribute_id='.$fn->getAttributeId())
            ->join(array('ce2' => 'customer_entity_varchar'), 'ce2.entity_id=main_table.`author_id`', array('lastname' => 'value'))
            ->where('ce2.attribute_id='.$ln->getAttributeId())
            ->columns(new Zend_Db_Expr("CONCAT(`ce1`.`value`, ' ',`ce2`.`value`) AS fullname"))
            ->where('ce2.entity_id=' . $params['id']);

        return $coll->getData();

    }

}