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
 * TrainEvent helper
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Helper_Trainevent extends Mage_Core_Helper_Url
{
    public function getProduct()
    {
        return Mage::registry('product');
    }

    public function getCustomer()
    {
        return Mage::getSingleton('customer/session')->getCustomer();
    }

    public function getSignupUrl(){
        return $this->_getUrl('wage_trainevent/trainevent/subscribe', array(
                'product_id'  => $this->getProduct()->getId(),  
                'customer'    => $this->getCustomer()->getEmail(),  
                 Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED => $this->getEncodedUrl()
            ));
    }
    
    public function getEmailUrl(){
         return $this->_getUrl('wage_trainevent/trainevent/subscribe');
    }
}
