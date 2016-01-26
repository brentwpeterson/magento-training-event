<?php
/**
 * Wage_TrainEvent extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Wage
 * @package        Wage_TrainEvent
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * TrainEvent admin edit tabs
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Block_Adminhtml_Trainevent_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('trainevent_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('wage_trainevent')->__('TrainEvent'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Wage_TrainEvent_Block_Adminhtml_Trainevent_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_trainevent',
            array(
                'label'   => Mage::helper('wage_trainevent')->__('TrainEvent'),
                'title'   => Mage::helper('wage_trainevent')->__('TrainEvent'),
                'content' => $this->getLayout()->createBlock(
                    'wage_trainevent/adminhtml_trainevent_edit_tab_options'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_trainevent',
                array(
                    'label'   => Mage::helper('wage_trainevent')->__('Store views'),
                    'title'   => Mage::helper('wage_trainevent')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'wage_trainevent/adminhtml_trainevent_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        $this->addTab(
            'products',
            array(
                'label' => Mage::helper('wage_trainevent')->__('Associated products'),
                'url'   => $this->getUrl('*/*/products', array('_current' => true)),
                'class' => 'ajax'
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve trainevent entity
     *
     * @access public
     * @return Wage_TrainEvent_Model_Trainevent
     * @author Ultimate Module Creator
     */
    public function getTrainevent()
    {
        return Mage::registry('current_trainevent');
    }
}
