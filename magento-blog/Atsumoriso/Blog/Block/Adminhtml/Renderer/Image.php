<?php

class Atsumoriso_Blog_Block_Adminhtml_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if(!empty($row->getPhotoPath())){
            $out = "<img src=". Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $row->getPhotoPath() . " width='97px'/>";
        } else {
            $out = 'No photo';
        }
        return $out;
    }
}