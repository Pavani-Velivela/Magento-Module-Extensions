<?php

namespace Born\GeoIp\Block\Adminhtml\Country\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Born\GeoIp\Model\CountryFactory;
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
     * @var CountryFactory
     */
    protected $countryFactory;

    /**
     * @param Context $context
     * @param CountryFactory $countryFactory
     */
    public function __construct(
        Context $context,
        CountryFactory $countryFactory
    ) {
        $this->context = $context;
        $this->countryFactory = $countryFactory;
    }

    public function getId()
    {
        try {
            return $this->countryFactory->create()->load(
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