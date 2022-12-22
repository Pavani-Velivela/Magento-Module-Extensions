<?php

namespace Born\GeoIp\Controller\Adminhtml\Country;

use Magento\Backend\App\Action;
use Born\GeoIp\Model\CountryFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Born_GeoIp::countrymapping';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var CountryFactory
     */
    private $CountryFactory;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param CountryFactory $countryFactory
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        CountryFactory $countryFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->countryFactory = $countryFactory;
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

            $model = $this->countryFactory->create();

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
                $this->dataPersistor->clear('country_entity');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the item.'));
            }
            $this->dataPersistor->set('country_entity', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}