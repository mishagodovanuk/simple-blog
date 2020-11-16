<?php

declare(strict_types=1);

namespace Simple\Blog\Controller\Adminhtml\Posts;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Simple\Blog\Model\PostRepository;
use Psr\Log\LoggerInterface as Logger;
use Simple\Helper\Data as BlogDataHelper;
use Magento\Framework\View\Result\Page;

/**
 * Class Edit
 *
 * @package Simple\Blog\Controller\Adminhtml\Posts
 */
class Edit extends Action
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Simple_Blog::posts_save';

    /**
     * Post repository.
     *
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * Logger.
     *
     * @var Logger
     */
    protected $logger;

    /**
     * Page factory.
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Blog data helper.
     *
     * @var \Simple\Helper\Data
     */
    protected $blogDataHelper;

    /**
     * Edit constructor.
     *
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Simple\Blog\Model\PostRepository          $postRepository
     * @param \Psr\Log\LoggerInterface                   $logger
     * @param \Simple\Helper\Data                        $blogDataHelper
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PostRepository $postRepository,
        Logger $logger,
        BlogDataHelper $blogDataHelper
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->postRepository = $postRepository;
        $this->logger = $logger;
        $this->blogDataHelper = $blogDataHelper;
    }

    /**
     * @return Page
     */
    protected function _initAction(): Page
    {
        $result = $this->resultPageFactory->create();
        $result->setActiveMenu('Simple_Blog::posts')
               ->addBreadcrumb(__('Create Post'), __('Create Post'))
               ->addBreadcrumb(__('Posts list'), __('Posts list'))
               ->getConfig()
               ->getTitle()
               ->prepend(__('Create post'));

        return $result;
    }

    /**
     * Edit post action.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $id = $this->getRequest()->getParam('id');
        $result = $this->_initAction();

        if ($id) {
            try {
                $post = $this->postRepository->getById($id);
                $result->getConfig()->getTitle()->prepend(__('Edit "%1"', $post->getTitle()));
                $result->addBreadcrumb(__('Edit Post'), __('Edit Post'));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Post was not deleted. No such post.'));
                $result = $this->resultRedirectFactory->create()->setPath($this->_redirect->getRefererUrl());
            }
            $this->blogDataHelper->setAdminEditProduct($post);
        }

        return $result;
    }
}
