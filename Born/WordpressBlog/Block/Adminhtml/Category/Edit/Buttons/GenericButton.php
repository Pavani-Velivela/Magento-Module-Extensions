<?php



namespace Born\WordpressBlog\Block\Adminhtml\Category\Edit\Buttons;



use Magento\Backend\Block\Widget\Context;

use Born\WordpressBlog\Model\CategoryFactory;

use Magento\Framework\Exception\NoSuchEntityException;


class GenericButton

{

   
    protected $context;



   
    protected $itemsFactory;



    

    public function __construct(

        Context $context,

        CategoryFactory $categoryFactory

    ) {

        $this->context = $context;

        $this->categoryFactory = $categoryFactory;

    }



    public function getItemId()

    {

        try {

            return $this->categoryFactory->create()->load(

                $this->context->getRequest()->getParam('id')

            )->getId();

        } catch (NoSuchEntityException $e) {

        }

        return null;

    }

    public function getUrl($route = '', $params = [])

    {

        return $this->context->getUrlBuilder()->getUrl($route, $params);

    }

}