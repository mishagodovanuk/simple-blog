<?php

declare(strict_types=1);

namespace Simple\Blog\Controller\Adminhtml\Posts;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Simple\Blog\Model\PostRepository;
use Psr\Log\LoggerInterface as Logger;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Class Delete
 *
 * @package Simple\Blog\Controller\Adminhtml\Posts
 */
class Delete extends Action
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Simple_Blog::posts_delete';

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
     * Delete constructor.
     *
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Simple\Blog\Model\PostRepository          $postRepository
     * @param \Psr\Log\LoggerInterface                   $logger
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PostRepository $postRepository,
        Logger $logger
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->postRepository = $postRepository;
        $this->logger = $logger;
    }

    /**
     * Delete post action.
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $id = $this->getRequest()->getParam('id');

        try {
            $this->postRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('Your comment was deleted.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Comment was not delete.'));
            $this->logger->error($e->getMessage());
        }

        return $this->resultRedirectFactory->create()->setPath($this->_redirect->getRefererUrl());
    }
}
