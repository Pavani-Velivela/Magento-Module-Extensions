<?php



namespace Born\WordpressBlog\Controller\Adminhtml\Post;



use Magento\Framework\Controller\ResultFactory;

use Magento\Backend\App\Action\Context;

use Magento\Ui\Component\MassAction\Filter;

use Born\WordpressBlog\Model\ResourceModel\Post\CollectionFactory;



class MassEnable extends \Magento\Backend\App\Action

{

    /**

     * Authorization level of a basic admin session

     *

     * @see _isAllowed()

     */

    const ADMIN_RESOURCE = 'Born_WordpressBlog::post';



    /**

     * @var Filter

     */

    protected $filter;



    /**

     * @var CollectionFactory

     */

    protected $CollectionFactory;



    /**

     * @param Context $context

     * @param Filter $filter

     * @param CollectionFactory $collectionFactory

     */

    public function __construct(Context $context, Filter $filter, CollectionFactory $CollectionFactory)

    {

        $this->filter = $filter;

        $this->CollectionFactory = $CollectionFactory;

        parent::__construct($context);

    }



    /**

     * Execute action

     *

     * @return \Magento\Backend\Model\View\Result\Redirect

     * @throws \Magento\Framework\Exception\LocalizedException|\Exception

     */

    public function execute()

    {

        $collection = $this->filter->getCollection($this->CollectionFactory->create());



        foreach ($collection as $item) {

            $item->setStatus('Enable');

            $item->save();

        }



        $this->messageManager->addSuccessMessage(

            __('A total of %1 record(s) have been enabled.', $collection->getSize())

        );



        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('blog/posts/posts');

    }

}