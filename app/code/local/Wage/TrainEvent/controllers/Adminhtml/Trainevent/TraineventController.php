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
 * TrainEvent admin controller
 *
 * @category    Wage
 * @package     Wage_TrainEvent
 * @author      Ultimate Module Creator
 */
class Wage_TrainEvent_Adminhtml_Trainevent_TraineventController extends Wage_TrainEvent_Controller_Adminhtml_TrainEvent
{
    /**
     * init the trainevent
     *
     * @access protected
     * @return Wage_TrainEvent_Model_Trainevent
     */
    protected function _initTrainevent()
    {
        $traineventId  = (int) $this->getRequest()->getParam('id');
        $trainevent    = Mage::getModel('wage_trainevent/trainevent');
        if ($traineventId) {
            $trainevent->load($traineventId);
        }
        Mage::register('current_trainevent', $trainevent);
        return $trainevent;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('wage_trainevent')->__('Promo Code'))
             ->_title(Mage::helper('wage_trainevent')->__('TrainEvents'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit trainevent - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $traineventId    = $this->getRequest()->getParam('id');
        $trainevent      = $this->_initTrainevent();
        if ($traineventId && !$trainevent->getId()) {
            $this->_getSession()->addError(
                Mage::helper('wage_trainevent')->__('This trainevent no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getTraineventData(true);
        if (!empty($data)) {
            $trainevent->setData($data);
        }
        Mage::register('trainevent_data', $trainevent);
        $this->loadLayout();
        $this->_title(Mage::helper('wage_trainevent')->__('Promo Code'))
             ->_title(Mage::helper('wage_trainevent')->__('TrainEvents'));
        if ($trainevent->getId()) {
            $this->_title($trainevent->getTrainevent());
        } else {
            $this->_title(Mage::helper('wage_trainevent')->__('Add trainevent'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new trainevent action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save trainevent - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('trainevent')) {
            try {
                $trainevent = $this->_initTrainevent();
                $trainevent->addData($data);
                $products = $this->getRequest()->getPost('products', -1);
                if ($products != -1) {
                    $trainevent->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
                }
                $schedules = $this->getRequest()->getPost('schedule', -1);
                if ($schedules != -1) {
                    $trainevent->setScheduleData($schedules);
                }
                $trainevent->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('wage_trainevent')->__('TrainEvent was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $trainevent->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setTraineventData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('wage_trainevent')->__('There was a problem saving the trainevent.')
                );
                Mage::getSingleton('adminhtml/session')->setTraineventData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('wage_trainevent')->__('Unable to find trainevent to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete trainevent - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $trainevent = Mage::getModel('wage_trainevent/trainevent');
                $trainevent->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('wage_trainevent')->__('TrainEvent was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('wage_trainevent')->__('There was an error deleting trainevent.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('wage_trainevent')->__('Could not find trainevent to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete trainevent - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $traineventIds = $this->getRequest()->getParam('trainevent');
        if (!is_array($traineventIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('wage_trainevent')->__('Please select trainevents to delete.')
            );
        } else {
            try {
                foreach ($traineventIds as $traineventId) {
                    $trainevent = Mage::getModel('wage_trainevent/trainevent');
                    $trainevent->setId($traineventId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('wage_trainevent')->__('Total of %d trainevents were successfully deleted.', count($traineventIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('wage_trainevent')->__('There was an error deleting trainevents.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $traineventIds = $this->getRequest()->getParam('trainevent');
        if (!is_array($traineventIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('wage_trainevent')->__('Please select trainevents.')
            );
        } else {
            try {
                foreach ($traineventIds as $traineventId) {
                $trainevent = Mage::getSingleton('wage_trainevent/trainevent')->load($traineventId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainevents were successfully updated.', count($traineventIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('wage_trainevent')->__('There was an error updating trainevents.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * get grid of products action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function productsAction()
    {
        $this->_initTrainevent();
        $this->loadLayout();
        $this->getLayout()->getBlock('trainevent.edit.tab.product')
            ->setTraineventProducts($this->getRequest()->getPost('trainevent_products', null));
        $this->renderLayout();
    }

    /**
     * get grid of products action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function productsgridAction()
    {
        $this->_initTrainevent();
        $this->loadLayout();
        $this->getLayout()->getBlock('trainevent.edit.tab.product')
            ->setTraineventProducts($this->getRequest()->getPost('trainevent_products', null));
        $this->renderLayout();
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'trainevent.csv';
        $content    = $this->getLayout()->createBlock('wage_trainevent/adminhtml_trainevent_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'trainevent.xls';
        $content    = $this->getLayout()->createBlock('wage_trainevent/adminhtml_trainevent_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'trainevent.xml';
        $content    = $this->getLayout()->createBlock('wage_trainevent/adminhtml_trainevent_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('wage_trainevent/trainevent');
    }
}
