<?php
declare(strict_types=1);

namespace Simple\Blog\Controller\Post;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Action\Action as MagentoAction;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class View
 *
 * @package Simple\Blog\Controller\Post
 */
class View extends MagentoAction
{
    /**
     * Page factory.
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $pageFactory;

    /**
     * Customer Session.
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * View constructor.
     *
     * @param \Magento\Framework\App\Action\Context      $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param \Magento\Customer\Model\Session            $customerSession
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CustomerSession $customerSession
    ) {
        $this->pageFactory = $pageFactory;
        $this->customerSession = $customerSession;

        parent::__construct($context);
    }

    /**
     * Execute.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute(): Page
    {
        $result = $this->pageFactory->create();
        $customer = $this->customerSession->getCustomer();
        //TODO Replace strings by constants.
        $result->getLayout()
               ->getBlock('simple.blog.comments.list')
               ->setData('simple_blog_customer', $customer);
        $result->getLayout()
               ->getBlock('simple.blog.comments.create')
               ->setData('simple_blog_customer', $customer);

        return $result;
    }
}
