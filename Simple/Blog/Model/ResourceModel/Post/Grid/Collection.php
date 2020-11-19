<?php

declare(strict_types=1);

namespace Simple\Blog\Model\ResourceModel\Post\Grid;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Simple\Blog\Model\ResourceModel\Post;
use Simple\Blog\Model\ResourceModel\Post\Collection as PostCollection;

/**
 * Class Collection
 *
 * @package Simple\Blog\Model\ResourceModel\Post\Grid
 */
class Collection extends PostCollection implements SearchResultInterface
{
    /**
     * Aggregations.
     *
     * @var AggregationInterface
     */
    private $aggregations;

    /**
     * Collection constructor.
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(Document::class, Post::class);
    }

    /**
     * Get aggregations.
     *
     * @return AggregationInterface
     */
    public function getAggregations(): AggregationInterface
    {
        return $this->aggregations;
    }

    /**
     * Set aggregations.
     *
     * @param AggregationInterface $aggregations
     *
     * @return void
     */
    public function setAggregations($aggregations): void
    {
        //TODO Fix this.
        $this->aggregations = $aggregations;
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        //TODO Fix this.
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     *
     * @return $this
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null): Collection
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount(): int
    {
        return (int)$this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     *
     * @return $this
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount): Collection
    {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     *
     * @return $this
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null): Collection
    {
        return $this;
    }
}
