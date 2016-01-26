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
 * TrainEvent front contrller
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_TraineventController extends Mage_Core_Controller_Front_Action
{
    const XML_PATH_EMAIL_RECIPIENT  = 'wage_trainevent/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'wage_trainevent/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'wage_trainevent/email/email_template';

    /**
      * default action
      *
      * @access public
      * @return void
      * @author Ultimate Module Creator
      */
    public function subscribeAction()
    {
        $session = Mage::getSingleton('catalog/session');
        $customer = Mage::getSingleton('customer/session');
        $isLogged = $customer->isLoggedIn();
        
        $backUrl    = $this->getRequest()->getParam(Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED);
        $productId  = (int) $this->getRequest()->getParam('product_id');
        $guestEmail  = $this->getRequest()->getParam('guest_email');

        $post = array();
        if(!$isLogged) {
            $post['email'] = $guestEmail;
            $post['product'] = $productId;
        }else{
            $post['email'] = $customer->getCustomer()->getEmail();
            $post['product'] = $productId;
        }

        if (!$backUrl) {
            $this->_redirect('/');
            return ;
        }

        if (!$product = Mage::getModel('catalog/product')->load($productId)) {
            
            $session->addError($this->__('Not enough parameters.'));
            $this->_redirectUrl($backUrl);
            return ;
        }

        try {          

                $translate = Mage::getSingleton('core/translate');
                $translate->setTranslateInline(false);
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                        null,
                        array('data' => $postObject)
                    );

                if (!$mailTemplate->getSentSuccess()) {
                    $session->addException($e, $this->__('Mail Not Sent.'));
                }

                $translate->setTranslateInline(true);


            $session->addSuccess($this->__('Event subscription has been sent.'));
        }
        catch (Exception $e) {
            $session->addException($e, $this->__('Unable to send Event subscription.'));
        }
        $this->_redirectReferer();
    }

}
