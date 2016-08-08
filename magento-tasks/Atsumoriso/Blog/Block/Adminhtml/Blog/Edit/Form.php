<?php

class Atsumoriso_Blog_Block_Adminhtml_Blog_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
//        if (Mage::getSingleton('adminhtml/session')->getExampleData()) {
//            $data = Mage::getSingleton('adminhtml/session')->getExamplelData();
//            Mage::getSingleton('adminhtml/session')->getExampleData(null);
        if (Mage::registry('post')) {
            $data = Mage::registry('post')->getData();
        } else {
            $data = array();
        }

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('edit_form', array(
            'legend' => Mage::helper('atsumoriso_blog')->__('Edit post #' )
        ));

        $fieldset->addField('headline', 'text', array(
            'label' 	=> Mage::helper('atsumoriso_blog')->__('Headline'),
            'class' 	=> 'required-entry', //js
            'required'  => true,             //backend validation
            'style'   => "width:800px",
            'name'  	=> 'headline',
            'note' 	=> Mage::helper('atsumoriso_blog')->__('Article headline.'),
        ));

        $fieldset->addField('text', 'textarea', array(
            'label' 	=> Mage::helper('atsumoriso_blog')->__('Text'),
            'class' 	=> 'required-entry',
            'style'     => "width:800px;height:400px",
            'required'  => true,
            'name'  	=> 'text',
            'note' 	=> Mage::helper('atsumoriso_blog')->__('Article content.'),
        ));


        $fieldset->addField('photo_path', 'image', array(
            'label' 	=> Mage::helper('atsumoriso_blog')->__('Photo'),
//            'after_element_html' => '<small>Previously added photo</small>',
            'value'     =>  'photo_path',
            'name'  	=>  'attachment',
        ));

        $form->setValues($data);

        return parent::_prepareForm();
    }
}


