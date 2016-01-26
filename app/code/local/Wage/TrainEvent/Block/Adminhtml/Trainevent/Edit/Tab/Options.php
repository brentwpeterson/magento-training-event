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
 * TrainEvent edit form tab
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Block_Adminhtml_Trainevent_Edit_Tab_Options extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('wage_trainevent/options.phtml');
    }

    /**
     * Preparing layout, adding buttons
     *
     * @return Mage_Eav_Block_Adminhtml_Attribute_Edit_Options_Abstract
     */
    protected function _prepareLayout()
    {
    	
    	$this->setChild('trainevent_form',
            $this->getLayout()->createBlock('wage_trainevent/adminhtml_trainevent_edit_tab_form')
            );
        $this->setChild('delete_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('wage_trainevent')->__('Delete'),
                    'class' => 'delete delete-option'
                )));

        $this->setChild('add_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('wage_trainevent')->__('Add Schedules'),
                    'class' => 'add',
                    'id'    => 'add_new_option_button'
                )));
        return parent::_prepareLayout();
    }

    /**
     * Retrieve HTML of form 
     *
     * @return string
     */
    public function getTrainEventFormHtml()
    {
        return $this->getChildHtml('trainevent_form');
    }

    /**
     * Retrieve HTML of delete button
     *
     * @return string
     */
    public function getDeleteButtonHtml()
    {
        return $this->getChildHtml('delete_button');
    }

    /**
     * Retrieve HTML of add button
     *
     * @return string
     */
    public function getAddNewButtonHtml()
    {
        return $this->getChildHtml('add_button');
    }

    /**
     * Retrieve attribute option values if attribute input type select or multiselect
     *
     * @return array
     */
    public function getOptionValues()
    {
    	$trainevent = $this->getTrainevent()->getId();
        $values = $this->getData('option_values');
        if (is_null($values)) {
            $values = array();

            if($trainevent) {
            	
	            $scheduleCollection = Mage::getResourceModel('wage_trainevent/trainevent_schedule_collection')
	            	->addTraineventFilter($trainevent)
	            	->setOrder('position');

	            foreach ($scheduleCollection as $schedule) {
	                $value = array();	                
	                $value['checked'] = '';
			        $value['intype'] = 'radio';
			        $value['id'] = $schedule->getId();
			        $value['title'] = $schedule->getTitle();
			        $value['threshold_qty'] = $schedule->getThresholdQty();
			        $value['price'] = $schedule->getPrice();
			        $value['section_days'] = $schedule->getSectionDays();
                    $value['position'] = $schedule->getPosition();
	                $values[] = new Varien_Object($value);
	            }
	            $this->setData('option_values', $values);
        	}
        }

        return $values;
    }


    /**
     * get the current trainevent
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
