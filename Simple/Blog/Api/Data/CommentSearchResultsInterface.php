<?php

namespace Simple\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface CommentSearchResultsInterface
 *
 * @package Simple\Blog\Api\Data
 */
interface CommentSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems();

    /**
     * Get items.
     *
     * @param array $items
     *
     * @return \Simple\Blog\Api\Data\CommentSearchResultsInterface
     */
    public function setItems(array $items);
}
