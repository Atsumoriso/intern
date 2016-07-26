<?php

class Atsumoriso_Blog_Model_Productbinded extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('blog/productbinded');
    }

    public function getBindedProductByPostId($id)
    {
        $post = Mage::getModel('blog/productbinded')->getCollection()
            ->addFieldToFilter('main_table.post_id', array('eq' => $id));

        $post
            ->getSelect()
            ->join(
                array('product_info_img' => 'catalog_product_entity_varchar'),
                "product_info_img.entity_id = main_table.product_id AND product_info_img.attribute_id = 85",
                array('product_info_img.value as image_url')
            )
            ->join(
                array('product_info_name' => 'catalog_product_entity_varchar'),
                "product_info_name.entity_id = main_table.product_id AND product_info_name.attribute_id = 71",
                array('product_info_name.value as name')
            )
            ->join(
                array('product_info_price' => 'catalog_product_entity_decimal'),
                "product_info_price.entity_id = main_table.product_id AND product_info_price.attribute_id = 75",
                array('product_info_price.value as price')
            )
            ->join(
                array('product_info_special_price' => 'catalog_product_entity_decimal'),
                "product_info_special_price.entity_id = main_table.product_id AND product_info_special_price.attribute_id = 76",
                array('product_info_special_price.value as price')
            )
            ->join(
                array('product_info_url_key' => 'catalog_product_entity_varchar'),
                "product_info_url_key.entity_id = main_table.product_id AND product_info_url_key.attribute_id = 97",
                array('product_info_url_key.value as url_key')
            )
            ->join(
                array('product_info_description' => 'catalog_product_entity_text'),
                "product_info_description.entity_id = main_table.product_id AND product_info_description.attribute_id = 72",
                array('product_info_description.value as description')
            );

        return $post;
    }


}