<?php

declare(strict_types=1);

namespace Simple\Blog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Simple\Blog\Model\Post as Model;
use Simple\Blog\Model\ResourceModel\Post as ResourceModel;

/**
 * Class Collection
 *
 * @package Simple\Blog\Model\ResourceModel\Post
 */
class Collection extends AbstractCollection
{
    /**
     * Construct.
     */
    public function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
