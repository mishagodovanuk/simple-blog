<?php

namespace Simple\Blog\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Simple\Blog\Api\Data;
use Simple\Blog\Api\PostRepositoryInterface;
use Simple\Blog\Model\PostFactory;
use Simple\Blog\Model\ResourceModel\Post as ResourcePost;
use Simple\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * Class PostRepository
 *
 * @package Simple\Blog\Model
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * Resource.
     *
     * @var \Simple\Blog\Model\ResourceModel\Post
     */
    private $resource;

    /**
     * Post factory.
     *
     * @var \Simple\Blog\Model\PostFactory
     */
    private $postFactory;

    /**
     * Post collection factory.
     *
     * @var \Simple\Blog\Model\ResourceModel\Post\CollectionFactory
     */
    private $postCollectionFactory;

    /**
     * Search result factory.
     *
     * @var \Simple\Blog\Api\Data\PostSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * PostRepository constructor.
     *
     * @param \Simple\Blog\Model\ResourceModel\Post                   $resource
     * @param \Simple\Blog\Model\PostFactory                          $postFactory
     * @param \Simple\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory
     * @param \Simple\Blog\Api\Data\PostSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        ResourcePost $resource,
        PostFactory $postFactory,
        PostCollectionFactory $postCollectionFactory,
        Data\PostSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save.
     *
     * @param \Simple\Blog\Api\Data\PostInterface $post
     *
     * @return mixed|\Simple\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(Data\PostInterface $post)
    {
        try {
            $this->resource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $post;
    }

    /**
     * Get by id.
     *
     * @param $postId
     *
     * @return mixed|\Simple\Blog\Model\Post
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($postId)
    {
        $post = $this->postFactory->create();
        $this->resource->load($post, $postId);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $postId));
        }

        return $post;
    }

    /**
     * Get list.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $criteria
     *
     * @return mixed|\Simple\Blog\Api\Data\PostSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria = null)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->postCollectionFactory->create();
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
     * @param \Simple\Blog\Api\Data\PostInterface $post
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(Data\PostInterface $post)
    {
        try {
            $this->resource->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete by id.
     *
     * @param $postId
     *
     * @return bool|mixed
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($postId)
    {
        return $this->delete($this->getById($postId));
    }
}
