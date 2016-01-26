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
 * Product helper
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Helper_Product extends Wage_TrainEvent_Helper_Data
{

    /**
     * get the selected trainevents for a product
     *
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return array()
     * @author Ultimate Module Creator
     */
    public function getSelectedTrainevents(Mage_Catalog_Model_Product $product)
    {
        if (!$product->hasSelectedTrainevents()) {
            $trainevents = array();
            foreach ($this->getSelectedTraineventsCollection($product) as $trainevent) {
                $trainevents[] = $trainevent;
            }
            $product->setSelectedTrainevents($trainevents);
        }
        return $product->getData('selected_trainevents');
    }

    /**
     * get trainevent collection for a product
     *
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return Wage_TrainEvent_Model_Resource_Trainevent_Collection
     * @author Ultimate Module Creator
     */
    public function getSelectedTraineventsCollection(Mage_Catalog_Model_Product $product)
    {
        $collection = Mage::getResourceModel('wage_trainevent/trainevent_collection')
            ->addStoreFilter(Mage::app()->getStore())
            ->addProductFilter($product);
        return $collection;
    }
}
