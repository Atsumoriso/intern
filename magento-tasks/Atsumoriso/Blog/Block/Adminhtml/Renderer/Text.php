<?php

class Atsumoriso_Blog_Block_Adminhtml_Renderer_Text extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return substr($row->getText(), 0, 50) . '...';
    }
}