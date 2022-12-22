<?php

namespace Born\SMSNotification\Block\Adminhtml\Templates\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Born\SMSNotification\Model\TemplatesFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var TemplatesFactory
     */
    protected $templatesFactory;

    /**
     * @param Context $context
     * @param TemplatesFactory $templatesFactory
     */
    public function __construct(
        Context $context,
        TemplatesFactory $templatesFactory
    ) {
        $this->context = $context;
        $this->templatesFactory = $templatesFactory;
    }

    public function getId()
    {
        try {
            return $this->templatesFactory->create()->load(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}