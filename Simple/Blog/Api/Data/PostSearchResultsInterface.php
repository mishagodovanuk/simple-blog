<?php

namespace Simple\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface PostSearchResultsInterface
 *
 * @package Simple\Blog\Api\Data
 */
interface PostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems();

    /**
     * Set items.
     *
     * @param array $items
     *
     * @return \Simple\Blog\Api\Data\PostSearchResultsInterface
     */
    public function setItems(array $items);
}
