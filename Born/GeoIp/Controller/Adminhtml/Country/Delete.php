<?php

namespace Born\GeoIp\Controller\Adminhtml\Country;

class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Born_GeoIp::countrymapping';

    protected $country;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Born\GeoIp\Model\Country $country
        )
    {
        parent::__construct($context);
        $this->country = $country;
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
                $country = $this->country->load($id);
                
                $country->delete();
                
                // display success message
                $this->messageManager->addSuccessMessage(__('The country has been deleted.'));
                
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