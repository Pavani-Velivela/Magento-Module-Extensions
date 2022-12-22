<?php
namespace Born\Subscription\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Born\Subscription\Block\Adminhtml\Form\Field\IntervalColumn;

/**
 * Class Subscriptionintervals
 */
class Subscriptionintervals extends AbstractFieldArray
{
    /**
     * @var IntervalColumn
     */
    private $intervalRenderer;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
          $this->addColumn('interval', [
            'label' => __('Interval Type'),
            'renderer' => $this->getIntervalRenderer()
        ]);
        $this->addColumn('Numberofinterval', ['label' => __('Number Of Interval'), 'class' => 'required-entry']);
        $this->addColumn('intervallabel', ['label' => __('Interval Label'), 'class' => 'required-entry']);
       
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Rule');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $interval = $row->getInterval();
        if ($interval !== null) {
            $options['option_' . $this->getIntervalRenderer()->calcOptionHash($interval)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @return IntervalColumn
     * @throws LocalizedException
     */
    private function getIntervalRenderer()
    {
        if (!$this->intervalRenderer) {
            $this->intervalRenderer = $this->getLayout()->createBlock(
                IntervalColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->intervalRenderer;
    }
}