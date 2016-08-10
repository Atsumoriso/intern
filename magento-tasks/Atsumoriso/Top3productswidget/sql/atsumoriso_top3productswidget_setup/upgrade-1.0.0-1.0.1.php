<?php

$widgetParameters = [
    'products_count' => 'Number of Products to display',
    'page_title' => 'Widget Title',
    'template' => 'widget/index.phtml',
];

$widgetInstance = Mage::getModel('widget/widget_instance')->setData([
    'type'             =>   'atsumoriso_top3productswidget/topwidget',    //value in admin part
    'package_theme'    =>   'PashustrikPackage/PashustrikTheme',          //value in admin part
    'title'            =>   'Title Widget install script',                          //value in admin part
    'store_ids'        =>   0,  // or comma separated list of ids
    'widget_parameters'       =>   serialize($widgetParameters),
    'page_groups'      =>   [
        'page_group'       =>  'all_pages',
        'all_pages'        =>  [
           // 'page_id'         => null,
            'group'           => 'all_pages',
            'layout_handle'   => 'default',
            'block'           => 'left',
            'for'             => 'all',
            'template'        => $widgetParameters['template'],
        ]
    ],
])->save();