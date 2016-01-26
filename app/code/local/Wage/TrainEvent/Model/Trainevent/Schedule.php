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
 * TrainEvent schedule model
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Model_Trainevent_Schedule extends Mage_Core_Model_Abstract
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
        $this->_init('wage_trainevent/trainevent_schedule');
    }

    /**
     * Save data for trainevent-schedule relation
     * @access public
     * @param  Wage_TrainEvent_Model_Trainevent $trainevent
     * @return Wage_TrainEvent_Model_Trainevent_Schedule
     * @author Ultimate Module Creator
     */
    public function saveTraineventRelation($trainevent)
    {
        $data = $trainevent->getScheduleData();
        if (!is_null($data)) {
            $this->_getResource()->saveTraineventRelation($trainevent, $data);
        }
        return $this;
    }

    /**
     * get schedule for trainevent
     *
     * @access public
     * @param Wage_TrainEvent_Model_Trainevent $trainevent
     * @return Wage_TrainEvent_Model_Resource_Trainevent_Schedule_Collection
     * @author Ultimate Module Creator
     */
    public function getScheduleCollection($trainevent)
    {
        $collection = Mage::getResourceModel('wage_trainevent/trainevent_schedule_collection')
            ->addTraineventFilter($trainevent);
        return $collection;
    }

}
