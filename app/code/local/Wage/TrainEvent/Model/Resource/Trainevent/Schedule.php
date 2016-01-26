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
 * TrainEvent - schedule relation model
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Model_Resource_Trainevent_Schedule extends Mage_Core_Model_Resource_Db_Abstract
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
        $this->_init('wage_trainevent/trainevent_schedule', 'schedule_id');
    }
    /**
     * Save trainevent - schedule relations
     *
     * @access public
     * @param Wage_TrainEvent_Model_Trainevent $trainevent
     * @param array $data
     * @return Wage_TrainEvent_Model_Resource_Trainevent_Schedule
     * @author Ultimate Module Creator
     */
    public function saveTraineventRelation($trainevent, $data)
    {
        if (!is_array($data)) {
            $data = array();
        }
        $helperCatalog = Mage::helper('catalog');
        foreach ($data as $key => $values) {
            $data[$key] = array_map(array($helperCatalog, 'stripTags'), $values);
        }

        $deleteCondition = $this->_getWriteAdapter()->quoteInto('trainevent_id=?', $trainevent->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $key => $info) {
            if($key == 'delete'){ continue; }
            if($data['delete'][$key] == 1){ continue; }
           
            $this->_getWriteAdapter()->insert(
                $this->getMainTable(),
                array(
                    'trainevent_id' => $trainevent->getId(),
                    'title'         => $info['title'],
                    'threshold_qty' => $info['threshold_qty'],
                    'price'         => $info['price'],
                    'section_days'  => $info['section_days'],
                    'position'  => $info['position']
                )
            );
        }
        return $this;
    }

}
