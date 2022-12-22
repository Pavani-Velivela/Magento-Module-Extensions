<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Born\WordpressBlog\Model\Resolver\Post;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Born\WordpressBlog\Model\Post;

/**
 * Identity for resolved products
 */
class Identity implements IdentityInterface
{
    /**
     * Get product ids for cache tag
     *
     * @param array $resolvedData
     * @return string[]
     */
    public function getIdentities(array $resolvedData): array
    {   
        $ids = [];
         return $ids;
     
        foreach ($resolvedData as $post) {
            $ids[] = sprintf('%s_%s', $post::CACHE_TAG, $post['id']);
        }
    
        return $ids;
    }
}
