<?php

namespace Born\WordpressBlog\Model;

use Born\WordpressBlog\Api\WordpressPostRepositoryInterface;
use Born\WordpressBlog\Api\Data\WordpressPostSearchResultsInterfaceFactory as SearchResultFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Born\WordpressBlog\Model\ResourceModel\Post\CollectionFactory;


class WordpressPostRepository implements WordpressPostRepositoryInterface

{
    public function __construct(
        \Born\WordpressBlog\Model\PostFactory $modelFactory,
        \Born\WordpressBlog\Model\ResourceModel\Post\CollectionFactory $collectionFactory,
        SearchResultFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }
    public function getById($id)

    {
        $model = $this->modelFactory->create();
        $model->load($id);
        return $model;
    }
    public function getList($searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }
    public function deleteById($id)
	{
		$model = $this->modelFactory->create();
		$model ->load($id);
		if($model ->getId()){
			$model ->delete();
			return true;
		}
		return false;
	}

       public function updateById($id)
	{
	}

        public function saveData($data)
	{
                         $id = $data['id'];
                         $title = $data['title'];
                         $description = $data['description'];
                         $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                         return 'successfully saved';
	}
}
