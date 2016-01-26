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
 * TrainEvent - product relation model
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Model_Resource_Trainevent_Product extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * initialize resource model
     *
     * @access protected
     * @see Mage_Core_Model_Resource_Abstract::_construct()
     * @author Ultimate Module Creator
     */
    protected function  _construct()
    {
        $this->_init('wage_trainevent/trainevent_product', 'rel_id');
    }
    /**
     * Save trainevent - product relations
     *
     * @access public
     * @param Wage_TrainEvent_Model_Trainevent $trainevent
     * @param array $data
     * @return Wage_TrainEvent_Model_Resource_Trainevent_Product
     * @author Ultimate Module Creator
     */
    public function saveTraineventRelation($trainevent, $data, $qtyData)
    {
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('trainevent_id=?', $trainevent->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $productId => $info) {
            $this->_getWriteAdapter()->insert(
                $this->getMainTable(),
                array(
                    'trainevent_id' => $trainevent->getId(),
                    'product_id'    => $productId,
                    'qty'           => @$info['qty'],
                    'position'      => @$info['position']
                )
            );
        }
        return $this;
    }

}
