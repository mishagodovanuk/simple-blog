<?php

declare(strict_types=1);

namespace Simple\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Simple\Blog\Api\Data\PostInterface;

/**
 * Class Post
 *
 * @package Simple\Blog\Model\ResourceModel
 */
class Post extends AbstractDb
{
    /**
     * Construct.
     */
    public function _construct()
    {
        $this->_init(PostInterface::TABLE_NAME, PostInterface::ID);
    }
}
