<?php
declare(strict_types=1);

namespace Simple\Blog\Controller\Comment;

use Magento\Framework\App\Action\Action as MagentoAction;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Simple\Blog\Model\CommentRepository;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Class Delete
 *
 * @package Simple\Blog\Controller\Comment
 */
class Delete extends MagentoAction
{
    /**
     * Comment repository.
     *
     * @var \Simple\Blog\Model\CommentRepository
     */
    protected $commentRepository;

    /**
     * Delete constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Simple\Blog\Model\CommentRepository  $commentRepository
     */
    public function __construct(
        Context $context,
        CommentRepository $commentRepository
    ) {
        $this->commentRepository = $commentRepository;
        parent::__construct($context);
    }

    /**
     * Execute.
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute(): Redirect
    {
        $result = $this->resultRedirectFactory->create();
        $result->setPath('*/*');

        $commentId = $this->getRequest()->getParam('id');
        if ($commentId) {
            try {
                if ($this->commentRepository->deleteById($commentId)) {
                    $this->messageManager->addSuccessMessage(__("Your comment was deleted"));
                    $result->setUrl($this->_redirect->getRefererUrl());
                }
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $result;
    }
}
