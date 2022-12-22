<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Model\Config\Source;
use Born\WordpressBlog\Model\ResourceModel\Category\CollectionFactory;


/**
 * Class Page
 */
class Url implements \Magento\Framework\Option\ArrayInterface
{
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * To option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = $this->collectionFactory->create()->toOptionIdArray();
        }
        return $this->options;
        //  return [
        //        ['value' => 'grid', 'label' => __('Grid Only')], 
        //        ['value' => 'list', 'label' => __('List Only')],

        //         ['value' => 0, 'label' => __('Custom No')]
        //      ];
        }
        
    }
