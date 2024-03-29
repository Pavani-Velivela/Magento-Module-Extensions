<?php



namespace Born\WordpressBlog\Controller\Post;



class Content extends \Magento\Framework\App\Action\Action

{

    protected $resultPageFactory;



    public function __construct(

        \Magento\Framework\App\Action\Context $context,

        \Magento\Framework\View\Result\PageFactory $resultPageFactory

        )

    {

        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;

    }



    public function execute()

    {

        $resultPage = $this->resultPageFactory->create();

        return $resultPage;

    }

}