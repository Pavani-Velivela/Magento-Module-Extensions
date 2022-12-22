<?php



namespace Born\WordpressBlog\Block\Adminhtml\Post\Edit\Buttons;


use Magento\Backend\Block\Widget\Context;

use Born\WordpressBlog\Model\PostFactory;

use Magento\Framework\Exception\NoSuchEntityException;





class GenericButton

{


    protected $context;   
    protected $itemsFactory;


    public function __construct(

        Context $context,

        PostFactory $postfactory

    ) {

        $this->context = $context;

        $this->postfactory = $postfactory;

    }



    public function getItemId()

    {

        try {

            return $this->postfactory->create()->load(

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