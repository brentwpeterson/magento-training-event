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
 * Observer
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */

class Wage_TrainEvent_Model_Observer
{    
    public function applyTraineventPrice($observer)
    {
        $event = $observer->getEvent();
        $product = $event->getProduct();  
        $stockItem = $product->getStockItem(); 
        $today = date("Y-m-d");

        if($product->getTypeID() == 'virtual')
        {
            $trainevents = array();

            $mainCollection = Mage::getResourceModel('wage_trainevent/trainevent_collection')
                        ->addFieldToFilter('status','1')
                        ->addFieldToFilter('start_date', array('lteq' => date("Y-m-d")))    
                        ->addFieldToFilter('end_date', array('gteq' => date("Y-m-d")))   
                        ->addStoreFilter(Mage::app()->getStore())
                        ->addProductFilter($product);
                            
            $firstCollection = $mainCollection->getFirstItem();
            $trainEventId = $firstCollection->getData('entity_id');

            if($trainEventId){
                $trainEventStartDate = strtotime($firstCollection->getData('start_date'));
                $soldqty = (int)$firstCollection->getData('qty');
                $trainEventCollection = Mage::getResourceModel('wage_trainevent/trainevent_schedule_collection')
                                        ->addTraineventFilter($trainEventId)
                                        ->setOrder('position', 'ASC');
                
                if(!empty($trainEventCollection->getData())){

                    foreach($trainEventCollection->getData() as $key => $value){
                        $dateEventPlus = date('Y-m-d', strtotime('+'.$value['section_days'].' day', $trainEventStartDate));
                        if($soldqty <= (int)$value['threshold_qty']){
                            if(strtotime($today) <= strtotime($dateEventPlus)){
                                //Mage::log(print_r($value['threshold_qty'], true));
                                $price = (int)$value['price']; 
                                $product->setFinalPrice($price); 
                                //Mage::log(print_r($price, true));  
                                break;
                            }
                        }
                    }
                }
            }                
        } 
        return $this;
    }

    public function eventProductStockUpdate($observer)
    {
        $order = $observer->getEvent()->getOrder();
        foreach ($order->getAllVisibleItems() as $item)
        {
            $productModel = Mage::getModel('catalog/product')->load($item->getProductId());
            //Mage::log(print_r($item->getProductId(), true));
            $mainCollection = Mage::getResourceModel('wage_trainevent/trainevent_collection')
                            ->addFieldToFilter('status','1')
                            ->addFieldToFilter('start_date', array('lteq' => date("Y-m-d")))    
                            ->addFieldToFilter('end_date', array('gteq' => date("Y-m-d")))   
                            ->addStoreFilter(Mage::app()->getStore())
                            ->addProductFilter($productModel);
                            
            $firstCollection = $mainCollection->getFirstItem();

            $trainEventProductId = $firstCollection->getData('rel_id');
            //Mage::log(print_r($trainEventProductId, true));
            if($trainEventProductId){
                $trainEventProductModel = Mage::getModel('wage_trainevent/trainevent_product')->load($trainEventProductId);
                $stock = (int)$item->getQtyOrdered() + (int)$trainEventProductModel->getQty();
                //Mage::log(print_r($stock, true));
                $trainEventProductModel->setQty($stock)->save();
                $ProdustIds[] = $stock;
            }
        }      
        //Mage::log(print_r($ProdustIds, true));
        
        return $this;
    }

    public function handleEventBlockAlert($observer) 
    {
        $product = Mage::registry('current_product'); 
        if ('product.info.addtocart' == $observer->getEvent()->getBlock()->getNameInLayout() && $product->getTypeId() == 'virtual') {
 
            $today = date("Y-m-d");  
            $mainCollection = Mage::getResourceModel('wage_trainevent/trainevent_collection')
                        ->addStoreFilter(Mage::app()->getStore())
                        ->addProductFilter($product);    
            
            $firstCollection = $mainCollection->getFirstItem();
            $trainEventEndDate = $firstCollection->getData('end_date');

            if(strtotime($today) >= strtotime($trainEventEndDate) && $trainEventEndDate){
                $isLogged = Mage::helper('customer')->isLoggedIn();
                if(!$isLogged) {
                    $transport = $observer->getEvent()->getTransport();
                    $alertBlock = Mage::app()->getLayout()->createBlock('wage_trainevent/trainevent_subscribe', 'event.subscribe');
                    $alertBlock->setTemplate('wage_trainevent/subscribe_guest.phtml');
                    $html = $alertBlock->toHtml();
                    $transport->setHtml($html);
                }else{
                    $transport = $observer->getEvent()->getTransport();
                    $alertBlock = Mage::app()->getLayout()->createBlock('wage_trainevent/trainevent_subscribe', 'event.subscribe');
                    $alertBlock->setTemplate('wage_trainevent/subscribe_customer.phtml');                    
                    $alertBlock->setHtmlClass('alert-stock link-stock-alert');
                    $alertBlock->setSignupLabel('Sign up to get notified to get next Event Planning'); 
                    $html = $alertBlock->toHtml();
                    $transport->setHtml($html);
                }
            }
        }
    }

}