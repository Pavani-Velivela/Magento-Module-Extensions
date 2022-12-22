<?php

namespace Born\SMSNotification\Controller\Adminhtml\Templates;

class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Born_SMSNotification::smstemplate';

    protected $templates;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Born\SMSNotification\Model\Templates $templates
        )
    {
        parent::__construct($context);
        $this->templates = $templates;
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
                $templates = $this->templates->load($id);
                
                $templates->delete();
                
                // display success message
                $this->messageManager->addSuccessMessage(__('The template has been deleted.'));
                
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