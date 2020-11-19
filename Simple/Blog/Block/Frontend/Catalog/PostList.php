<?php
declare(strict_types=1);

namespace Simple\Blog\Block\Frontend\Catalog;

use Magento\Framework\View\Element\Template;
use Simple\Blog\Api\Data\PostInterface;
use Simple\Blog\Model\ResourceModel\Post\Collection as PostCollection;
use Simple\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Catalog\Helper\Image as ImageHelper;
use Simple\Blog\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;

/**
 * Class PostList
 *
 * @package Simple\Blog\Block\Frontend\Catalog
 */
class PostList extends Template
{
    /**
     * Post collection.
     *
     * @var \Simple\Blog\Model\ResourceModel\Post\CollectionFactory
     */
    protected $postCollection;

    /**
     * Comment collection factory.
     *
     * @var \Simple\Blog\Model\ResourceModel\Comment\CollectionFactory
     */
    protected $commentCollectionFactory;

    /**
     * Image helper.
     *
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * Posts.
     *
     * @var
     */
    protected $posts;

    /**
     * Comments.
     *
     * @var
     */
    protected $comments;

    /**
     * PostList constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context           $context
     * @param \Simple\Blog\Model\ResourceModel\Post\CollectionFactory    $postCollection
     * @param \Magento\Catalog\Helper\Image                              $imageHelper
     * @param \Simple\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionFactory
     * @param array                                                      $data
     */
    public function __construct(
        Template\Context $context,
        PostCollectionFactory $postCollection,
        ImageHelper $imageHelper,
        CommentCollectionFactory $commentCollectionFactory,
        array $data = []
    ) {
        $this->postCollection = $postCollection;
        $this->imageHelper = $imageHelper;
        $this->commentCollectionFactory = $commentCollectionFactory;

        parent::__construct($context, $data);
    }

    /**
     * Prepare layout.
     *
     * @return $this|\Simple\Blog\Block\Frontend\Catalog\PostList
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Post listing'));
        $posts = $this->getPosts();

        if ($posts) {
            $pager = $this->getChildBlock('simple.blog.posts.pager');
            $pager->setAvailableLimit([
                5 => 5,
                10 => 10,
                15 => 15
            ])->setShowPerPage(false)
              ->setShowAmounts(false)
              ->setCollection($this->getPosts());
        }
        $posts->load();

        return $this;
    }

    /**
     * Get page Header.
     *
     * @return string
     */
    public function getPageHeader(): string
    {
        return "Post list";
    }

    /**
     * Get posts.
     *
     * @return \Simple\Blog\Model\ResourceModel\Post\Collection
     */
    public function getPosts()
    {
        if ($this->posts == null) {
            $this->posts = $this->postCollection->create()
                                                ->addFieldToFilter(PostInterface::ACTIVE, 1)
                                                ->setOrder(PostInterface::CREATED_AT, PostCollection::SORT_ORDER_DESC);
        }

        return $this->posts;
    }

    /**
     * Get image url.
     *
     * @param $image
     *
     * @return string
     */
    public function getImageUrl($image): string
    {
        return $this->imageHelper->getPlaceholder();
    }

    /**
     * Get post view url.
     *
     * @param $id
     *
     * @return string
     */
    public function getPostViewUrl($id): string
    {
        return $this->getUrl('simpleblog/post/view', ['id' => $id]);
    }

    /**
     * Get comments count.
     *
     * @param $id
     *
     * @return int|mixed
     */
    public function getCommentsCount($id)
    {
        if ($this->comments == null) {
            $this->comments = $this->commentCollectionFactory->create()
                                                             ->addFieldToFilter('post_id', ['in' => $this->getPosts()->getColumnValues('entity_id')]);
        }
        $postId = $this->comments->getColumnValues('post_id');
        $commentCount = array_count_values($postId);

        return array_key_exists($id, $commentCount) ? $commentCount[$id] : 0;
    }
}
