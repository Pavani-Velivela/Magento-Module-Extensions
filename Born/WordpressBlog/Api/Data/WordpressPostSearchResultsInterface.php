<?php

namespace Born\WordpressBlog\Api\Data;

/**
 * posts collection
 */
interface WordpressPostSearchResultsInterface

{
    /**
     * @return \Born\WordpressBlog\Api\Data\WordpressPostInterface[]
     */
    public function getItems();

    /**
     * @param \Born\WordpressBlog\Api\Data\WordpressPostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
   /**
     * @param int $count
     * @return $this
     */
    public function setTotalCount($count);
     
    /**
     * @return int
     */
    public function getTotalCount();
}
