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
 * Admin search model
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Model_Adminhtml_Search_Trainevent extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Wage_TrainEvent_Model_Adminhtml_Search_Trainevent
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('wage_trainevent/trainevent_collection')
            ->addFieldToFilter('trainevent', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $trainevent) {
            $arr[] = array(
                'id'          => 'trainevent/1/'.$trainevent->getId(),
                'type'        => Mage::helper('wage_trainevent')->__('TrainEvent'),
                'name'        => $trainevent->getTrainevent(),
                'description' => $trainevent->getTrainevent(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/trainevent_trainevent/edit',
                    array('id'=>$trainevent->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
