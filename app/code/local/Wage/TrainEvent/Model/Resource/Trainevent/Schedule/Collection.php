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
 * TrainEvent - schedule relation resource model collection
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Model_Resource_Trainevent_Schedule_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected $_joinedFields = array();

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
        $this->_init('wage_trainevent/trainevent_schedule');
    }

    /**
     * add trainevent filter
     *
     * @access public
     * @param Wage_TrainEvent_Model_Trainevent | int $trainevent
     * @return Wage_TrainEvent_Model_Resource_Trainevent_Schedule_Collection
     * @author Ultimate Module Creator
     */
    public function addTraineventFilter($trainevent)
    {
        if ($trainevent instanceof Wage_TrainEvent_Model_Trainevent) {
            $trainevent = $trainevent->getId();
        }
       
        $this->getSelect()->where('main_table.trainevent_id = ?', $trainevent);
        return $this;
    }
}
