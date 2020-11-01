<?php

namespace Simple\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Simple\Blog\Api\Data\PostInterface;

/**
 * Interface PostRepositoryInterface
 *
 * @package Simple\Blog\Api
 */
interface PostRepositoryInterface
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
     * @param \Simple\Blog\Api\Data\PostInterface $object
     *
     * @return mixed
     */
    public function save(PostInterface $object);

    /**
     * Delete by id.
     *
     * @param $object
     *
     * @return mixed
     */
    public function deleteById($object);
}
