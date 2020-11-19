<?php

declare(strict_types=1);

namespace Simple\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Simple\Blog\Api\Data\CommentInterface;

/**
 * Class Comment
 *
 * @package Simple\Blog\Model\ResourceModel
 */
class Comment extends AbstractDb
{
    /**
     * Construct.
     */
    public function _construct()
    {
        $this->_init(CommentInterface::TABLE_NAME, CommentInterface::ID);
    }
}
