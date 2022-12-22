<?php

namespace Born\WordpressBlog\Controller\Adminhtml\Categories;

class Delete extends \Magento\Backend\App\Action

{

    const ADMIN_RESOURCE = 'Born_WordpressBlog::categories';

     protected $category;
          public function __construct(

        \Magento\Backend\App\Action\Context $context,

        \Born\WordpressBlog\Model\Category $category

        )

    {

        parent::__construct($context);

        $this->category = $category;

    }


    public function execute()

    {

        
        $id = $this->getRequest()->getParam('id');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */

        $resultRedirect = $this->resultRedirectFactory->create();

        

        if ($id) {

            try {

                // init model and delete

                $items = $this->category->load($id);

                

                $items->delete();

                

                // display success message

                $this->messageManager->addSuccessMessage(__('The item has been deleted.'));

                

                return $resultRedirect->setPath('blog/categories/category');

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

        return $resultRedirect->setPath('blog/categories/category');

    }

}