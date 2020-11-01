<?php

namespace Simple\Blog\Block\Frontend\Catalog\Comments;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\View\Element\Template;
use Simple\Blog\Api\Data\CommentInterface;
use Simple\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;
use Simple\Blog\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;
use Simple\Blog\Model\CommentRepository;

/**
 * Class Comments
 *
 * @package Simple\Blog\Block\Frontend\Catalog\Comments
 */
class Comments extends Template
{
    /**
     * Comments collection.
     *
     * @var \Simple\Blog\Model\ResourceModel\Comment\CollectionFactory
     */
    protected $commentsCollection;

    /**
     * Comments.
     *
     * @var
     */
    protected $comments;

    /**
     * Comments repository.
     *
     * @var \Simple\Blog\Model\CommentRepository
     */
    protected $commentRepository;

    /**
     * Customer session.
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * Customer url.
     *
     * @var \Magento\Customer\Model\Url
     */
    protected $customerUrl;

    /**
     * Comments constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context           $context
     * @param \Simple\Blog\Model\ResourceModel\Comment\CollectionFactory $commentsCollection
     * @param \Magento\Customer\Model\Session                            $customerSession
     * @param \Magento\Customer\Model\Url                                $customerUrl
     * @param \Simple\Blog\Model\CommentRepository                       $commentRepository
     * @param array                                                      $data
     */
    public function __construct(
        Template\Context $context,
        CommentCollectionFactory $commentsCollection,
        CustomerSession $customerSession,
        CustomerUrl $customerUrl,
        CommentRepository $commentRepository,
        array $data = []
    ) {
        $this->commentsCollection = $commentsCollection;
        $this->commentRepository = $commentRepository;
        $this->customerSession = $customerSession;
        $this->customerUrl = $customerUrl;
        parent::__construct($context, $data);
    }

    /**
     * Prepare layout.
     *
     * @return $this|\Simple\Blog\Block\Frontend\Catalog\Comments\Comments
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if ($this->getNameInLayout() == 'simple.blog.comments.create') {
            return $this;
        }

        $comments = $this->getComments();
        if ($comments) {
            $pager = $this->getChildBlock('simple.blog.comment.pager');
            $pager->setAvailableLimit([
                5 => 5,
                10 => 10,
                15 => 15
            ])->setShowPerPage(false)
              ->setShowAmounts(false)
              ->setCollection($comments);
        }
        $comments->load();

        return $this;
    }

    /**
     * Get post id.
     *
     * @return string
     */
    public function getPostId(): string
    {
        return $this->_request->getParam('id');
    }

    /**
     * Get comments.
     *
     * @return \Simple\Blog\Model\ResourceModel\Comment\Collection
     */
    public function getComments()
    {
        if ($this->comments == null) {
            $this->comments = $this->commentsCollection->create()
                                                       ->addFieldToFilter(CommentInterface::POST_ID, $this->getPostId())
                                                       ->setOrder(CommentInterface::CREATED_AT, CommentCollection::SORT_ORDER_DESC);
        }

        return $this->comments;
    }

    /**
     * Is user loged in.
     *
     * @return bool
     */
    public function isUserLogedIn(): bool
    {
        return (bool)$this->customerSession->isLoggedIn();
    }

    /**
     * Get create comment action.
     *
     * @return string
     */
    public function getCreateCommentAction(): string
    {
        return $this->getUrl('simpleblog/comment/create');
    }

    /**
     * Get login url.
     *
     * @return string
     */
    public function getLoginUrl(): string
    {
        return $this->customerUrl->getLoginUrl();
    }

    /**
     * Get user id.
     *
     * @return string
     */
    public function getUserId(): string
    {
        return $this->customerSession->getCustomerId();
    }

    /**
     * Get edit url.
     *
     * @param $id
     *
     * @return string
     */
    public function getEditUrl($id): string
    {
        return $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true, 'edit_id' => $id]);
    }

    /**
     * Get delete url.
     *
     * @param $id
     *
     * @return string
     */
    public function getDeleteUrl($id): string
    {
        return $this->getUrl('simpleblog/comment/delete', ['id' => $id]);
    }

    /**
     * Get edit comment.
     *
     * @return false|mixed|\Simple\Blog\Model\Comment
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getEditComment()
    {
        $result = false;
        $commentId = $this->getRequest()->getParam('edit_id');
        if ($commentId) {
            $result = $this->commentRepository->getById($commentId);
            if ($result->getUserId() != $this->getUserId()) {
                $result = false;
            }
        }

        return $result;
    }
}
