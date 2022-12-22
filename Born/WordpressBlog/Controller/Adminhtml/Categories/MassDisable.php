<?php



namespace Born\WordpressBlog\Controller\Adminhtml\Categories;



use Magento\Framework\Controller\ResultFactory;

use Magento\Backend\App\Action\Context;

use Magento\Ui\Component\MassAction\Filter;

use Born\WordpressBlog\Model\ResourceModel\Category\CollectionFactory;



class MassDisable extends \Magento\Backend\App\Action

{

    /**

     * Authorization level of a basic admin session

     *

     * @see _isAllowed()

     */

    const ADMIN_RESOURCE = 'Born_WordpressBlog::categories';



    /**

     * @var Filter

     */

    protected $filter;



    /**

     * @var CollectionFactory

     */

    protected $collectionFactory;



    /**

     * @param Context $context

     * @param Filter $filter

     * @param CollectionFactory $collectionFactory

     */

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)

    {

        $this->filter = $filter;

        $this->collectionFactory = $collectionFactory;

        parent::__construct($context);

    }


    public function execute()

    {

        $collection = $this->filter->getCollection($this->collectionFactory->create());



        foreach ($collection as $item) {

            $item->setStatus(false);

            $item->save();

        }



        $this->messageManager->addSuccessMessage(

            __('A total of %1 record(s) have been disabled.', $collection->getSize())

        );



        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('blog/categories/category');

    }

}