<?php

namespace Simple\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Simple\Blog\Api\Data\CommentInterface;

/**
 * Interface CommentRepositoryInterface
 *
 * @package Simple\Blog\Api
 */
interface CommentRepositoryInterface
{
    /**
     * Get by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getById($id);

    /**
     * Get list.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     *
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null);

    /**
     * Save.
     *
     * @param \Simple\Blog\Api\Data\CommentInterface $object
     *
     * @return mixed
     */
    public function save(CommentInterface $object);

    /**
     * Delete by id.
     *
     * @param $object
     *
     * @return mixed
     */
    public function deleteById($object);

    /**
     * Get by post id.
     *
     * @param $postId
     *
     * @return mixed
     */
    public function getByPostId($postId);

    /**
     * Get by user id.
     *
     * @param $userId
     *
     * @return mixed
     */
    public function getByUserId($userId);
}
