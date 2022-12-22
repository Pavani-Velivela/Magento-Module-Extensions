<?php

namespace Born\WordpressBlog\Controller\Adminhtml\Categories;



use Magento\Backend\App\Action;

use Born\WordpressBlog\Model\CategoryFactory;

use Magento\Framework\App\Request\DataPersistorInterface;

use Magento\Framework\Exception\LocalizedException;



class Save extends \Magento\Backend\App\Action

{

    
    const ADMIN_RESOURCE = 'Born_WordpressBlog::categories';





    protected $dataPersistor;



    

    private $itemsFactory;




    public function __construct(

        Action\Context $context,

        DataPersistorInterface $dataPersistor,

        CategoryFactory $categoryfactory

    ) {

        $this->dataPersistor = $dataPersistor;

        $this->categoryfactory = $categoryfactory;

        parent::__construct($context);

    }

    public function execute()

    {

        $data = $this->getRequest()->getPostValue();

        // echo "<pre>";print_r($data);exit;
        

        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {

            if (isset($data['status']) && $data['status'] === 'true') {

                $data['status'] = true;

            }

            if (empty($data['id'])) {

                $data['id'] = null;

            }



            $model = $this->categoryfactory->create();



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

                $this->dataPersistor->clear('category_entry');

                if ($this->getRequest()->getParam('back')) {

                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);

                }

                return $resultRedirect->setPath('blog/categories/category');

            } catch (LocalizedException $e) {

                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);

            } catch (\Exception $e) {

                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the item.'));

            }



            $this->dataPersistor->set('category_entry', $data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('item_id')]);

        }

        return $resultRedirect->setPath('blog/categories/category');

    }

}