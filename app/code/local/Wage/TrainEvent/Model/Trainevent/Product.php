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
 * TrainEvent product model
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Model_Trainevent_Product extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource
     *
     * @access protected
     * @return void
     * @author Ultimate Module Creator
     */
    protected function _construct()
    {
        $this->_init('wage_trainevent/trainevent_product');
    }

    /**
     * Save data for trainevent-product relation
     * @access public
     * @param  Wage_TrainEvent_Model_Trainevent $trainevent
     * @return Wage_TrainEvent_Model_Trainevent_Product
     * @author Ultimate Module Creator
     */
    public function saveTraineventRelation($trainevent)
    {
        $data = $trainevent->getProductsData();
        if (!is_null($data)) {
            $this->_getResource()->saveTraineventRelation($trainevent, $data);
        }
        return $this;
    }

    /**
     * get products for trainevent
     *
     * @access public
     * @param Wage_TrainEvent_Model_Trainevent $trainevent
     * @return Wage_TrainEvent_Model_Resource_Trainevent_Product_Collection
     * @author Ultimate Module Creator
     */
    public function getProductCollection($trainevent)
    {
        $collection = Mage::getResourceModel('wage_trainevent/trainevent_product_collection')
            ->addTraineventFilter($trainevent);
        return $collection;
    }
}
