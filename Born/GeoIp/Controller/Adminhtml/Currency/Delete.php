<?php

namespace Born\GeoIp\Controller\Adminhtml\Currency;

class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Born_GeoIp::currencymapping';

    protected $currency;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Born\GeoIp\Model\Currency $currency
        )
    {
        parent::__construct($context);
        $this->currency = $currency;
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($id) {
            try {
                // init model and delete
                $currency = $this->currency->load($id);
                
                $currency->delete();
                
                // display success message
                $this->messageManager->addSuccessMessage(__('The currency has been deleted.'));
                
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a item to delete.'));
        
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}