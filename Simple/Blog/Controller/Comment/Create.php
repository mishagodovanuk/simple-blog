<?php
declare(strict_types=1);

namespace Simple\Blog\Controller\Comment;

use Magento\Framework\App\Action\Action as MagentoAction;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Simple\Blog\Model\CommentRepository;
use Simple\Blog\Model\Comment;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Class Create
 *
 * @package Simple\Blog\Controller\Comment
 */
class Create extends MagentoAction
{
    /**
     * Comment model.
     *
     * @var \Simple\Blog\Model\Comment
     */
    protected $commentModel;

    /**
     * Comment repository.
     *
     * @var \Simple\Blog\Model\CommentRepository
     */
    protected $commentRepository;

    /**
     * Create constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Simple\Blog\Model\CommentRepository  $commentRepository
     * @param \Simple\Blog\Model\Comment            $comment
     */
    public function __construct(
        Context $context,
        CommentRepository $commentRepository,
        Comment $comment
    ) {
        $this->commentRepository = $commentRepository;
        $this->commentModel = $comment;
        parent::__construct($context);
    }

    /**
     * Execute.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute(): Redirect
    {
        $result = $this->resultRedirectFactory->create();
        $result->setPath('*/*');

        $data = $this->getRequest()->getParams();
        if ($data) {
            try {
                if (array_key_exists('form_key', $data)) {
                    unset($data['form_key']);
                }

                $model = $this->commentModel->setData($data);
                $model->setActive(1);
                if ($this->commentRepository->save($model)) {
                    $this->messageManager->addSuccessMessage(__("Your comment was saved"));
                    $result->setPath('*/post/view', ['id' => $model->getPostId()]);
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
