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
class Wage_TrainEvent_Block_Adminhtml_Trainevent_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Wage_TrainEvent_Block_Adminhtml_Trainevent_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('trainevent_');
        $form->setFieldNameSuffix('trainevent');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'trainevent_form',
            array('legend' => Mage::helper('wage_trainevent')->__('TrainEvent'))
        );

        $fieldset->addField(
            'trainevent',
            'text',
            array(
                'label' => Mage::helper('wage_trainevent')->__('Training Events'),
                'name'  => 'trainevent',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'start_date', 
            'date', 
            array(
                'label' => Mage::helper('wage_trainevent')->__('Start Date'),
                'required' => true,
                'name' => 'start_date',
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'value' => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT))
            )
        );

        $fieldset->addField(
            'end_date', 
            'date', 
            array(
                'label' => Mage::helper('wage_trainevent')->__('End Date'),
                'required' => true,
                'name' => 'end_date',
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'value' => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT))
            )
        );

        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('wage_trainevent')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('wage_trainevent')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('wage_trainevent')->__('Disabled'),
                    ),
                ),
            )
        );
        
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_trainevent')->setStoreId(Mage::app()->getStore(true)->getId());
        }
       
        $formValues = Mage::registry('current_trainevent')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getTraineventData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getTraineventData());
            Mage::getSingleton('adminhtml/session')->setTraineventData(null);
        } elseif (Mage::registry('current_trainevent')) {
            $formValues = array_merge($formValues, Mage::registry('current_trainevent')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
