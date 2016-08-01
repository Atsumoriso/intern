<?php

class Atsumoriso_Blog_Block_Adminhtml_Blog_Post_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('blog_post_id');
        $this->setDefaultSort('fullname');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $coll = Mage::getModel('blog/post')->getCollection();

        $fn = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'firstname');
        $ln = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'lastname');

        $coll->getSelect()
            ->join(array('first_name' => 'customer_entity_varchar'), 'first_name.entity_id=main_table.`author_id`', array('firstname' => 'value'))
            ->where('first_name.attribute_id='.$fn->getAttributeId()
            )
            ->join(array('last_name' => 'customer_entity_varchar'), 'last_name.entity_id=main_table.`author_id`', array('lastname' => 'value'))
            ->where('last_name.attribute_id='.$ln->getAttributeId())
            ->columns(new Zend_Db_Expr("CONCAT(`first_name`.`value`, ' ',`last_name`.`value`) AS fullname")
        );

        $this->setCollection($coll);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('atsumoriso_blog');

        $this->addColumn('post_id', array(
            'header' => $helper->__('Post ID'),
            'width' => '30px',
            'index'  => 'post_id'
        ));

        $this->addColumn('is_active', array(
            'header'  => $helper->__('Status'),
            'index'   => 'is_active',
            'type'    => 'options',
            'options' => Mage::getSingleton('blog/post')->getStatusesArray(),
            'width'   => '30px',
        ));

        $this->addColumn('headline', array(
            'header' => $helper->__('Headline'),
            'index'  => 'headline'
        ));

        $this->addColumn('text', array(
            'header'       => $helper->__('Article content brief'),
            //default substr of big text
            'type'         => 'text',
            'index'        => 'text',
            //or my custom substr, or other processing
            'renderer'     => 'Atsumoriso_Blog_Block_Adminhtml_Renderer_Text',
        ));

        $this->addColumn('fullname', array(
            'header'                    => $helper->__('Author'),
////            'filter_condition_callback' => array($this, '_nameFilter'),
            'index'                     => 'fullname',
        ));

        $this->addColumn('photo_path', array(
            'header'   => $helper->__('Photo uploaded'),
            'index'    => 'photo_path',
            'renderer' => 'Atsumoriso_Blog_Block_Adminhtml_Renderer_Image',
        ));

        $this->addColumn('created_at', array(
            'header' => $helper->__('Date published'),
            'index'  => 'created_at'
        ));


        $this->addExportType('*/*/exportInchooCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportInchooExcel', $helper->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getPostId()));
    }

    protected function _prepareMassaction()
    {
        //delete
        $this->setMassactionIdField('post_to_delete');
        $this->getMassactionBlock()->setFormFieldName('post_to_delete');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('atsumoriso_blog')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete', array('' => '')),        // public function massDeleteAction() in Blog_Adminhtml_Blog_PostController
            'confirm' => Mage::helper('atsumoriso_blog')->__('Are you sure?')
        ));

        $statuses = Atsumoriso_Blog_Model_Post::getStatusesArray();//Mage::getSingleton('blog/post')->getStatusesArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('atsumoriso_blog')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('atsumoriso_blog')->__('Status'),
                    'values' => $statuses
                )
            )
        ));

        return $this;
    }
//
//    protected function _nameFilter($collection, $column)
//    {
//        if (!$value = $column->getFilter()->getValue())
//        {
//            return $this;
//        }
//
//        $this->getCollection()->getSelect()
//            ->where( "cev1.value like ?
//            OR cev2.value like ?"
//                , "%$value%");
//        return $this;
//    }

}