<?php
declare(strict_types=1);

namespace Simple\Blog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Simple\Blog\Api\Data\PostInterface;
use Simple\Blog\Model\ResourceModel\Post as ResourceModel;

/**
 * Class Post
 *
 * @package Simple\Blog\Model
 */
class Post extends AbstractModel implements IdentityInterface, PostInterface
{
    /**
     * Cache tag.
     */
    const CACHE_TAG = 'simple_blog_post';

    /**
     * Event prefix.
     *
     * @var string
     */
    public $eventPrefix = 'simple_blog_post';

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
     * @return mixed|\Simple\Blog\Model\Post
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
     * Set title.
     *
     * @param string $title
     *
     * @return mixed|\Simple\Blog\Model\Post
     */
    public function setTitle(string $title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return mixed|\Simple\Blog\Model\Post
     */
    public function setText(string $text)
    {
        return $this->setData(self::TEXT, $text);
    }

    /**
     * Get text.
     * @return array|mixed|string|null
     */
    public function getText()
    {
        return $this->getData(self::TEXT);
    }

    /**
     * Set image.
     *
     * @param string $image
     *
     * @return mixed|\Simple\Blog\Model\Post
     */
    public function setImage(string $image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Ser active.
     *
     * @param $active
     *
     * @return mixed|\Simple\Blog\Model\Post
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
     * Set created at.
     *
     * @param $date
     *
     * @return mixed|\Simple\Blog\Model\Post
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
     * @return mixed|\Simple\Blog\Model\Post
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
