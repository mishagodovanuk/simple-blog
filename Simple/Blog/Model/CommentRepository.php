<?php

namespace Simple\Blog\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Simple\Blog\Api\Data;
use Simple\Blog\Api\CommentRepositoryInterface;
use Simple\Blog\Model\ResourceModel\Comment as ResourceComment;
use Simple\Blog\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;

/**
 * Class CommentRepository
 *
 * @package Simple\Blog\Model
 */
class CommentRepository implements CommentRepositoryInterface
{
    /**
     * Resource.
     *
     * @var \Simple\Blog\Model\ResourceModel\Comment
     */
    private $resource;

    /**
     * Comment factory.
     *
     * @var \Simple\Blog\Model\CommentFactory
     */
    private $commentFactory;

    /**
     * Comment collection factory.
     *
     * @var \Simple\Blog\Model\ResourceModel\Comment\CollectionFactory
     */
    private $commentCollectionFactory;

    /**
     * Search result factory.
     *
     * @var \Simple\Blog\Api\Data\CommentSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * CommentRepository constructor.
     *
     * @param \Simple\Blog\Model\ResourceModel\Comment                   $resource
     * @param \Simple\Blog\Model\CommentFactory                          $commentFactory
     * @param \Simple\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionFactory
     * @param \Simple\Blog\Api\Data\CommentSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        ResourceComment $resource,
        CommentFactory $commentFactory,
        CommentCollectionFactory $commentCollectionFactory,
        Data\CommentSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->commentFactory = $commentFactory;
        $this->commentCollectionFactory = $commentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save.
     *
     * @param \Simple\Blog\Api\Data\CommentInterface $comment
     *
     * @return mixed|\Simple\Blog\Api\Data\CommentInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(Data\CommentInterface $comment)
    {
        try {
            $this->resource->save($comment);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $comment;
    }

    /**
     * Get by id.
     *
     * @param $commentId
     *
     * @return mixed|\Simple\Blog\Model\Comment
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($commentId)
    {
        $comment = $this->commentFactory->create();
        $this->resource->load($comment, $commentId);
        if (!$comment->getId()) {
            throw new NoSuchEntityException(__('Comment with id "%1" does not exist.', $commentId));
        }

        return $comment;
    }

    /**
     * Get list.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $criteria
     *
     * @return mixed|\Simple\Blog\Api\Data\CommentSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria = null)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->commentCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $post = [];
        /** @var Data\PostInterface $postModel */
        foreach ($collection as $postModel) {
            $post[] = $postModel;
        }
        $searchResults->setItems($post);

        return $searchResults;
    }

    /**
     * Delete.
     *
     * @param \Simple\Blog\Api\Data\CommentInterface $comment
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(Data\CommentInterface $comment)
    {
        try {
            $this->resource->delete($comment);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete by id.
     *
     * @param $commentId
     *
     * @return bool|mixed
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($commentId)
    {
        return $this->delete($this->getById($commentId));
    }

    /**
     * Get by post id.
     *
     * @param $postId
     *
     * @return mixed|\Simple\Blog\Model\ResourceModel\Comment\Collection
     */
    public function getByPostId($postId)
    {
        return  $this->commentCollectionFactory->create()
                                               ->addFilter('post_id', $postId);
    }

    /**
     * Get by user id.
     *
     * @param $userId
     *
     * @return mixed|\Simple\Blog\Model\ResourceModel\Comment\Collection
     */
    public function getByUserId($userId)
    {
        return $this->commentCollectionFactory->create()
                                              ->addFilter('user_id', $userId);
    }
}
