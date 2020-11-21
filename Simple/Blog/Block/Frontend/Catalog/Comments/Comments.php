<?php

namespace Simple\Blog\Block\Frontend\Catalog\Comments;

use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\View\Element\Template;
use Simple\Blog\Api\Data\CommentInterface;
use Simple\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;
use Simple\Blog\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;
use Simple\Blog\Model\CommentRepository;
use Magento\Customer\Model\Customer;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Customer\Model\Context as CustomerContext;

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
     * @var \Simple\Blog\Model\ResourceModel\Comment\Collection
     */
    protected $comments;

    /**
     * Comments repository.
     *
     * @var \Simple\Blog\Model\CommentRepository
     */
    protected $commentRepository;

    /**
     * Customer url.
     *
     * @var \Magento\Customer\Model\Url
     */
    protected $customerUrl;

    /**
     * Http context.
     *
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    /**
     * Comments constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context           $context
     * @param \Simple\Blog\Model\ResourceModel\Comment\CollectionFactory $commentsCollection
     * @param \Magento\Customer\Model\Url                                $customerUrl
     * @param \Simple\Blog\Model\CommentRepository                       $commentRepository
     * @param \Magento\Framework\App\Http\Context                        $httpContext
     * @param array                                                      $data
     */
    public function __construct(
        Template\Context $context,
        CommentCollectionFactory $commentsCollection,
        CustomerUrl $customerUrl,
        CommentRepository $commentRepository,
        HttpContext $httpContext,
        array $data = []
    ) {
        $this->commentsCollection = $commentsCollection;
        $this->commentRepository = $commentRepository;
        $this->customerUrl = $customerUrl;
        $this->httpContext = $httpContext;
        parent::__construct($context, $data);
    }

    /**
     * Prepare layout.
     *
     * @return $this|\Simple\Blog\Block\Frontend\Catalog\Comments\Comments
     */
    protected function _prepareLayout(): Comments
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
    public function getComments(): CommentCollection
    {
        if ($this->comments == null) {
            $this->comments = $this->commentsCollection->create()
                                                       ->addFieldToFilter(CommentInterface::POST_ID, $this->getPostId())
                                                       ->setOrder(CommentInterface::CREATED_AT, CommentCollection::SORT_ORDER_DESC);
        }

        return $this->comments;
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
     * Get edit url.
     *
     * @param string $id
     *
     * @return string
     */
    public function getEditUrl(string $id): string
    {
        return $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true, 'edit_id' => $id]);
    }

    /**
     * Get delete url.
     *
     * @param string $id
     *
     * @return string
     */
    public function getDeleteUrl(string $id): string
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

    /**
     * Get customer.
     *
     * @return \Magento\Customer\Model\Customer|null
     */
    protected function getCustomer(): ?Customer
    {
        return $this->getData('simple_blog_customer');
    }

    /**
     * Get user id.
     *
     * @return string|null
     */
    public function getUserId(): ?string
    {
        $result = null;
        if ($this->getCustomer()) {
            $result = $this->getCustomer()->getId();
        }

        return $result;
    }

    /**
     * Is user loged in.
     *
     * @return bool|null
     */
    public function isUserLogedIn(): ?bool
    {
        return $this->httpContext->getValue(CustomerContext::CONTEXT_AUTH);
    }
}
