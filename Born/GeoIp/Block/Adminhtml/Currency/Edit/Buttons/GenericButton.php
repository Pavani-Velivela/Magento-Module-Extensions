<?php

namespace Born\GeoIp\Block\Adminhtml\Currency\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Born\GeoIp\Model\CurrencyFactory;
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
     * @var CurrencyFactory
     */
    protected $currencyFactory;

    /**
     * @param Context $context
     * @param CurrencyFactory $currencyFactory
     */
    public function __construct(
        Context $context,
        CurrencyFactory $currencyFactory
    ) {
        $this->context = $context;
        $this->currencyFactory = $currencyFactory;
    }

    public function getId()
    {
        try {
            return $this->currencyFactory->create()->load(
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