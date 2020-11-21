<?php

declare(strict_types=1);

namespace Simple\Blog\Controller\Adminhtml\Posts;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface as Logger;
use Simple\Blog\Api\Data\PostInterface;
use Simple\Blog\Model\Post\Image\Uploader;
use Simple\Blog\Model\PostFactory;
use Simple\Blog\Model\PostRepository;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Class Edit
 *
 * @package Simple\Blog\Controller\Adminhtml\Posts
 */
class Save extends Action
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
     * Post factory.
     *
     * @var \Simple\Blog\Model\PostFactory
     */
    protected $postFactory;

    /**
     * Save constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Simple\Blog\Model\PostRepository   $postRepository
     * @param \Psr\Log\LoggerInterface            $logger
     * @param \Simple\Blog\Model\PostFactory      $postFactory
     */
    public function __construct(
        Context $context,
        PostRepository $postRepository,
        Logger $logger,
        PostFactory $postFactory
    ) {
        parent::__construct($context);
        $this->postRepository = $postRepository;
        $this->logger = $logger;
        $this->postFactory = $postFactory;
    }

    /**
     * Save action.
     *
     * @return \Magento\Framework\App\ResponseInterface|Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute(): Redirect
    {
        $result = $this->resultRedirectFactory->create()
                                              ->setPath($this->_redirect->getRefererUrl());
        $data = $this->getRequest()->getParams();

        if ($data) {
            if ($data[PostInterface::IMAGE]) {
                $image = reset($data[PostInterface::IMAGE]);
                $url = Uploader::FILE_PATH . '/' . $image['file'];
                $data[PostInterface::IMAGE] = $url;
            }

            $data = $this->removeFormData($data);

            if (array_key_exists(PostInterface::ID, $data)) {
                try {
                    $model = $this->postRepository->getById($data[PostInterface::ID]);
                } catch (NoSuchEntityException $e) {
                    $this->logger->error($e);
                    $this->messageManager->addErrorMessage(__('Something went wrong in post save process.'));
                }
            } else {
                $model = $this->postFactory->create();
            }
            /** @var \Simple\Blog\Model\Post $model */

            $model->setData($data);

            try {
                $this->postRepository->save($model);
                $this->messageManager->addSuccessMessage(__('Post was saved.'));
                if (!array_key_exists(PostInterface::ID, $data)) {
                    $result->setPath('*/*/edit', ['id' => $model->getId()]);
                }
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->messageManager->addErrorMessage(__('Something went wrong in post save process.'));
            }
        }

        return $result;
    }

    /**
     * Remove form data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function removeFormData(array $data): array
    {
        unset($data['key']);
        unset($data['form_key']);

        return $data;
    }
}
