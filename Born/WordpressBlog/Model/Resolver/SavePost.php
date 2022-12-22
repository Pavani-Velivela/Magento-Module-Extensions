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
use Born\WordpressBlog\Model\PostFactory;

class SavePost implements ResolverInterface
{
  
    public function __construct(PostFactory $postFactory )
   {
		$this->postFactory = $postFactory;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
          $title = $args['title'];
          $description = $args['description'] ?? "Default description";

          $model = $this->postFactory->create();
          $model->setData(['title' => $title, 'descriotion' => $description]);
         $model->save();
          return $model->getData();
    }
}