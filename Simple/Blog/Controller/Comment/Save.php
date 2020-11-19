<?php
declare(strict_types=1);

namespace Simple\Blog\Controller\Comment;

use Magento\Framework\App\Action\Action as MagentoAction;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Simple\Blog\Model\CommentRepository;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Class Save
 *
 * @package Simple\Blog\Controller\Comment
 */
class Save extends MagentoAction
{
    /**
     * Comment repository.
     *
     * @var \Simple\Blog\Model\CommentRepository
     */
    protected $commentRepository;

    /**
     * Save constructor.
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

        $data = $this->getRequest()->getParams();
        if ($data) {
            try {
                if (array_key_exists('form_key', $data)) {
                    unset($data['form_key']);
                }

                $model = $this->commentRepository->getById($data['id']);
                $model->setData($data);
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
