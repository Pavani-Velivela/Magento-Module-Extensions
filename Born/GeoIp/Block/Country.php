<?php
namespace Born\GeoIp\Block\Adminhtml;

class Country extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_country';
        $this->_blockGroup = 'Born_GeoIp';
        $this->_headerText = __('General');

        parent::_construct();

        if ($this->_isAllowedAction('Born_GeoIp::save')) {
            $this->buttonList->update('add', 'label', __('Add New'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}