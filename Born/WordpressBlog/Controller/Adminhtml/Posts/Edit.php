<?php

namespace Born\WordpressBlog\Controller\Adminhtml\Posts;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
   
    const ADMIN_RESOURCE = 'Born_WordpressBlog::wordpress_posts';
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Born\WordpressBlog\Model\PostFactory $postFactory
    ) 
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->PostFactory = $postFactory;
        parent::__construct($context);
    }

    
    protected function _initAction()
    {
        
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Born_WordpressBlog::wordpress_posts');
        return $resultPage;
    }

    
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->PostFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This item no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('post_entry', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Item') : __('New Item'),
            $id ? __('Edit Item') : __('New Item')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Item'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Item'));

        return $resultPage;
    }
}