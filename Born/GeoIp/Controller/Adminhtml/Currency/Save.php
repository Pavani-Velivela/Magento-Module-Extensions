<?php

namespace Born\GeoIp\Controller\Adminhtml\Currency;

use Magento\Backend\App\Action;
use Born\GeoIp\Model\CurrencyFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Born_GeoIp::currencymapping';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var CurrencyFactory
     */
    private $currencyFactory;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param CurrencyFactory $currencyFactory
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        CurrencyFactory $currencyFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->currencyFactory = $currencyFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
         $data = $this->getRequest()->getPostValue();
        
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
        
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $model = $this->currencyFactory->create();

            $id = $this->getRequest()->getParam('id');

            if ($id) {
                try {
                    $model->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This item no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
        
            $model->setData($data);
           try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the item.'));
                $this->dataPersistor->clear('currency_entity');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the item.'));
            }
            $this->dataPersistor->set('currency_entity', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}