<?php



namespace Born\WordpressBlog\Controller\Adminhtml\Posts;



class Delete extends \Magento\Backend\App\Action

{

    const ADMIN_RESOURCE = 'Born_WordpressBlog::posts';
          protected $post;
          public function __construct(

        \Magento\Backend\App\Action\Context $context,

        \Born\WordpressBlog\Model\Post $post

        )

    {

        parent::__construct($context);

        $this->post = $post;

    }


    public function execute()

    {

        // check if we know what should be deleted

        $id = $this->getRequest()->getParam('id');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */

        $resultRedirect = $this->resultRedirectFactory->create();

        

        if ($id) {

            try {

                // init model and delete

                $items = $this->post->load($id);

                

                $items->delete();

                

                // display success message

                $this->messageManager->addSuccessMessage(__('The item has been deleted.'));

                

                return $resultRedirect->setPath('blog/posts/posts');

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

        return $resultRedirect->setPath('blog/posts/posts');

    }

}