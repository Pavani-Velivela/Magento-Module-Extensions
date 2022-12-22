<?php

namespace Born\SMSNotification\Controller\Adminhtml\Templates;

use Magento\Backend\App\Action;
use Born\SMSNotification\Model\TemplatesFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Born_SMSNotification::smstemplate';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var TemplatesFactory
     */
    private $TemplatesFactory;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param TemplatesFactory $templatesFactory
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        TemplatesFactory $templatesFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->templatesFactory = $templatesFactory;
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

            $model = $this->templatesFactory->create();

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
                $this->dataPersistor->clear('templates_entry');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the item.'));
            }
            $this->dataPersistor->set('templates_entry', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('item_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}