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
 * TrainEvent model
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Model_Trainevent extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'wage_trainevent_trainevent';
    const CACHE_TAG = 'wage_trainevent_trainevent';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'wage_trainevent_trainevent';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'trainevent';
    protected $_productInstance = null;
    protected $_scheduleInstance = null;

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('wage_trainevent/trainevent');
    }

    /**
     * before save trainevent
     *
     * @access protected
     * @return Wage_TrainEvent_Model_Trainevent
     * @author Ultimate Module Creator
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save trainevent relation
     *
     * @access public
     * @return Wage_TrainEvent_Model_Trainevent
     * @author Ultimate Module Creator
     */
    protected function _afterSave()
    {
        $this->getProductInstance()->saveTraineventRelation($this);
        $this->getScheduleInstance()->saveTraineventRelation($this);
        return parent::_afterSave();
    }

    /**
     * get product relation model
     *
     * @access public
     * @return Wage_TrainEvent_Model_Trainevent_Product
     * @author Ultimate Module Creator
     */
    public function getProductInstance()
    {
        if (!$this->_productInstance) {
            $this->_productInstance = Mage::getSingleton('wage_trainevent/trainevent_product');
        }
        return $this->_productInstance;
    }

    /**
     * get schedule relation model
     *
     * @access public
     * @return Wage_TrainEvent_Model_Trainevent_Schedule
     * @author Ultimate Module Creator
     */
    public function getScheduleInstance()
    {
        if (!$this->_scheduleInstance) {
            $this->_scheduleInstance = Mage::getSingleton('wage_trainevent/trainevent_schedule');
        }
        return $this->_scheduleInstance;
    }

    /**
     * get selected products array
     *
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getSelectedProducts()
    {
        if (!$this->hasSelectedProducts()) {
            $products = array();
            foreach ($this->getSelectedProductsCollection() as $product) {
                $products[] = $product;
            }
            $this->setSelectedProducts($products);
        }
        return $this->getData('selected_products');
    }

    /**
     * Retrieve collection selected products
     *
     * @access public
     * @return Wage_TrainEvent_Resource_Trainevent_Product_Collection
     * @author Ultimate Module Creator
     */
    public function getSelectedProductsCollection()
    {
        $collection = $this->getProductInstance()->getProductCollection($this);
        return $collection;
    }


    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}
