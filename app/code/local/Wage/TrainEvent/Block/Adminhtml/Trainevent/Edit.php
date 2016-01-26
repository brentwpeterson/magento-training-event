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
 * TrainEvent admin edit form
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Block_Adminhtml_Trainevent_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'wage_trainevent';
        $this->_controller = 'adminhtml_trainevent';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('wage_trainevent')->__('Save TrainEvent')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('wage_trainevent')->__('Delete TrainEvent')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('wage_trainevent')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_trainevent') && Mage::registry('current_trainevent')->getId()) {
            return Mage::helper('wage_trainevent')->__(
                "Edit TrainEvent '%s'",
                $this->escapeHtml(Mage::registry('current_trainevent')->getTrainevent())
            );
        } else {
            return Mage::helper('wage_trainevent')->__('Add TrainEvent');
        }
    }
}
