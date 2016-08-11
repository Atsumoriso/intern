<?php

class Atsumoriso_Top3productswidget_Block_Topwidget
                extends Mage_Core_Block_Template
                implements Mage_Widget_Block_Interface
{
    public function getTop3Products()
    {
        $products = Mage::getModel('atsumoriso_top3productswidget/topwidget')->getTopProducts();
        return $products;
    }

    public function getTop3ProductsWidgetParams()
    {
        $widgetCollection = $this->_getWidgetCollection();
        $widget = $widgetCollection->getFirstItem();
        $widgetParameters = unserialize($widget->getData('widget_parameters'));
        return $widgetParameters;
    }

    protected function _getWidgetCollection()
    {
        $widgetCollection = Mage::getModel('widget/widget_instance')->getCollection()
            ->addFieldToFilter('type', ['eq' => 'atsumoriso_top3productswidget/topwidget']);
        return $widgetCollection;
    }


}
