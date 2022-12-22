<?php

namespace Born\WordpressBlog\Api;
/**
*Get Post details
*/

interface WordpressPostRepositoryInterface
{
    /** 
   *It is used to get element by using id 
   *@param int $id
   *@return \Born\WordpressBlog\Api\Data\WordpressPostInterface
   *@throws \Magento\Framework\Exception\LocalizedException
   */
    
    public function getById($id);
    /**
     * It get the list of posts 
     * @param \Magento\Framework\Api\SearchCriteriaInterface
     * @return \Born\WordpressBlog\Api\Data\WordpressPostSearchResultsInterface
     */
    public function getList($searchCriteria);
   
	/**
                     *It deletes post by id
	   *@param int $id
	   *@return bool true on success          
	   * @throws \Magento\Framework\Exception\LocalizedException
	   */
     public function deleteById($id);

     /**
     * Updates the specified posts.
     *
     * @param int $id
     * @return \Born\WordpressBlog\Api\Data\WordpressPostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateById($id);

     /**
     * save posts.
     *
     * @param \Born\WordpressBlog\Api\Data\WordpressPostInterface
     * @return \Born\WordpressBlog\Api\Data\WordpressPostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveData($data);
}