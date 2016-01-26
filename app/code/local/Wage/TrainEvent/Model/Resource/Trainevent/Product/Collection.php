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
 * TrainEvent - product relation resource model collection
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Model_Resource_Trainevent_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection
{
    /**
     * remember if fields have been joined
     *
     * @var bool
     */
    protected $_joinedFields = false;

    /**
     * join the link table
     *
     * @access public
     * @return Wage_TrainEvent_Model_Resource_Trainevent_Product_Collection
     * @author Ultimate Module Creator
     */
    public function joinFields()
    {
        if (!$this->_joinedFields) {
            $this->getSelect()->join(
                array('related' => $this->getTable('wage_trainevent/trainevent_product')),
                'related.product_id = e.entity_id',
                array('*')
            );
            $this->_joinedFields = true;
        }
        return $this;
    }

    /**
     * add trainevent filter
     *
     * @access public
     * @param Wage_TrainEvent_Model_Trainevent | int $trainevent
     * @return Wage_TrainEvent_Model_Resource_Trainevent_Product_Collection
     * @author Ultimate Module Creator
     */
    public function addTraineventFilter($trainevent)
    {
        if ($trainevent instanceof Wage_TrainEvent_Model_Trainevent) {
            $trainevent = $trainevent->getId();
        }
        if (!$this->_joinedFields ) {
            $this->joinFields();
        }
        $this->getSelect()->where('related.trainevent_id = ?', $trainevent);
        return $this;
    }
}
