<?php

namespace Born\CronScheduler\Block\Adminhtml\Schedule;

use Magento\Backend\Block\Template;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class RunButton
 * @package Born\CronScheduler\Block\Adminhtml\Schedule
 */
class RunButton extends Template implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $message = __('Are you sure you want to do this?');

        return [
            'id'       => 'apply',
            'label'    => __('Run All'),
            'on_click' => "deleteConfirm('" . $message . "', '" . $this->getUrl('*/*/run') . "')",
            'class'    => 'secondary'
        ];
    }
}
