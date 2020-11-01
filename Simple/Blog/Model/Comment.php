<?php
declare(strict_types=1);

namespace Simple\Blog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Simple\Blog\Api\Data\CommentInterface;
use Simple\Blog\Model\ResourceModel\Comment as ResourceModel;

/**
 * Class Comment
 *
 * @package Simple\Blog\Model
 */
class Comment extends AbstractModel implements IdentityInterface, CommentInterface
{
    /**
     * Cache tag.
     */
    const CACHE_TAG = 'simple_blog_comment';

    /**
     * Event prefix.
     *
     * @var string
     */
    public $eventPrefix = 'simple_blog_comment';

    /**
     * Construct.
     */
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Get identities.
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Set id.
     *
     * @param mixed $id
     *
     * @return mixed|\Simple\Blog\Model\Comment
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get id.
     *
     * @return array|mixed|string|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return mixed|\Simple\Blog\Model\Comment
     */
    public function setText(string $text)
    {
        return $this->setData(self::TEXT, $text);
    }

    /**
     * Get text.
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->getData(self::TEXT);
    }

    /**
     * Set post id.
     *
     * @param $postId
     *
     * @return mixed|\Simple\Blog\Model\Comment
     */
    public function setPostId($postId)
    {
        return $this->setData(self::POST_ID, $postId);
    }

    /**
     * Get post id.
     *
     * @return string
     */
    public function getPostId(): string
    {
        return $this->getData(self::POST_ID);
    }

    /**
     * Set user id.
     *
     * @param $userId
     *
     * @return mixed|\Simple\Blog\Model\Comment
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Get user id.
     *
     * @return string
     */
    public function getUserId(): string
    {
        return $this->getData(self::USER_ID);
    }

    /**
     * Set active.
     *
     * @param $active
     *
     * @return mixed|\Simple\Blog\Model\Comment
     */
    public function setActive($active)
    {
        return $this->setData(self::ACTIVE, $active);
    }

    /**
     * Get active.
     *
     * @return string
     */
    public function getActive(): string
    {
        return $this->getData(self::ACTIVE);
    }

    /**
     * Ser created at.
     *
     * @param $date
     *
     * @return mixed|\Simple\Blog\Model\Comment
     */
    public function setCreatedAt($date)
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * Get created at.
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set updated at.
     *
     * @param $date
     *
     * @return mixed|\Simple\Blog\Model\Comment
     */
    public function setUpdatedAt($date)
    {
        return $this->setData(self::UPDATED_AT, $date);
    }

    /**
     * Get updated at.
     *
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }
}
