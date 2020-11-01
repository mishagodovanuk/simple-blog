<?php

namespace Simple\Blog\Model\ResourceModel\Comment;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Simple\Blog\Model\Comment as Model;
use Simple\Blog\Model\ResourceModel\Comment as ResourceModel;

/**
 * Class Collection
 *
 * @package Simple\Blog\Model\ResourceModel\Comment
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

    /**
     * Init select.
     *
     * @return $this|\Simple\Blog\Model\ResourceModel\Comment\Collection|void
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->joinLeft(
            ['customer_entity' => 'customer_entity'],
            'customer_entity.entity_id = main_table.user_id',
            ['user_first_name' => 'customer_entity.firstname']
        );

        return $this;
    }
}
