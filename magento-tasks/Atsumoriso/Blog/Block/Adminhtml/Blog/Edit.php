<?php

class Atsumoriso_Blog_Block_Adminhtml_Blog_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'atsumoriso_blog'; //alias
        $this->_controller = 'adminhtml_blog'; //here no class name needed - only block folder structure - path inside Block folder
        $this->_mode = 'edit';

        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);
        $this->_updateButton('save', 'label', Mage::helper('atsumoriso_blog')->__('Save'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }
 
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('post') && Mage::registry('post')->getPostId())
        {
            return Mage::helper('atsumoriso_blog')->__('Edit article # %d', $this->htmlEscape(Mage::registry('post')->getPostId()));
        } else {
            return Mage::helper('atsumoriso_blog')->__('New Example');
        }
    }

}


