<?php

namespace Born\WordpressBlog\Model\Post;

use Born\WordpressBlog\Model\ResourceModel\Post\CollectionFactory;

use Magento\Framework\App\Request\DataPersistorInterface;


class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider

{


    public function __construct(

        $name,

        $primaryFieldName,

        $requestFieldName,

        CollectionFactory $collectionFactory,

        DataPersistorInterface $dataPersistor,

        array $meta = [],

        array $data = []

    ) {

        $this->collection = $collectionFactory->create();

        $this->dataPersistor = $dataPersistor;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->meta = $this->prepareMeta($this->meta);

    }


    public function prepareMeta(array $meta)

    {

        return $meta;

    }


    public function getData()

    {

        if (isset($this->loadedData)) {

            return $this->loadedData;

        }

        $items = $this->collection->getItems();


        if($items){
        foreach ($items as $item) {

            $this->loadedData[$item->getId()] = $item->getData();

        }
    }




        $data = $this->dataPersistor->get('post_entry');

        if (!empty($data)) {

            $item = $this->collection->getNewEmptyItem();

            $item->setData($data);

            $this->loadedData[$item->getId()] = $item->getData();

            $this->dataPersistor->clear('post_entry');

        }



        return $this->loadedData;

    }

}