<?php

declare(strict_types=1);

namespace Simple\Blog\Controller\Adminhtml\Comments;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\Page;

/**
 * Class Index
 *
 * @package Simple\Blog\Controller\Adminhtml\Comments
 */
class Index extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Simple_Blog::comments';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute(): Page
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Simple_Blog::comments');
        $resultPage->addBreadcrumb(__('Blog Comments'), __('Blog Comments'));
        $resultPage->addBreadcrumb(__('Blog Comments'), __('Blog Comments'));
        $resultPage->getConfig()->getTitle()->prepend(__('Blog Comments'));

        return $resultPage;
    }
}
