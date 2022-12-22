<?php

namespace Born\WordpressBlog\Model\Resolver;

use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\CatalogGraphQl\Model\Resolver\Products\Query\Filter;
use Magento\CatalogGraphQl\Model\Resolver\Products\Query\Search;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\SearchFilter;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Born\WordpressBlog\Model\ResourceModel\Post\CollectionFactory;

class PostResolver implements ResolverInterface
{
  
    public function __construct(CollectionFactory $collectionFactory )
   {
		$this->collectionFactory = $collectionFactory;
    }

   
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
          $pageSize = $args['pageSize'];
          $currentPage = $args['currentPage'];

          $collection = $this->collectionFactory->create();
          $collection->setPageSize($pageSize);
          $collection->setCurPage($currentPage);
          return $collection->getData();
    }
}