<?php
namespace Born\WordpressBlog\Controller\Adminhtml\Posts;
use Magento\Backend\App\Action;
use Born\WordpressBlog\Model\PostFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Born_WordpressBlog::wordpress_posts';


    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        PostsFactory $postFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->PostsFactory = $postFactory;
        parent::__construct($context);
    }

    
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            // if (isset($data['status']) && $data['status'] === 'true') {
            //     $data['status'] = true;
            // }
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $model = $this->PostFactory->create();

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
                $this->dataPersistor->clear('post_entry');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('blog/posts/posts');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the item.'));
            }

            $this->dataPersistor->set('wordpress_entry', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('blog/posts/posts');
    }
}