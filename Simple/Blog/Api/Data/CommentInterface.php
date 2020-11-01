<?php

namespace Simple\Blog\Api\Data;

/**
 * Interface CommentInterface
 *
 * @package Simple\Blog\Api\Data
 */
interface CommentInterface
{
    /**
     * Table name.
     */
    const TABLE_NAME = 'simple_blog_comment';

    /**#@+
     * Constants defined for keys of data array.
     */
    const ID = 'entity_id';
    const TEXT = 'text';
    const POST_ID = 'post_id';
    const USER_ID = 'user_id';
    const ACTIVE = 'active';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**#@-*/

    /**
     * Set id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function setId($id);

    /**
     * Get id.
     *
     * @return string
     */
    public function getId();

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return mixed
     */
    public function setText(string $text);

    /**
     * Get text.
     *
     * @return string
     */
    public function getText();

    /**
     * Set post id.
     *
     * @param $postId
     *
     * @return mixed
     */
    public function setPostId($postId);

    /**
     * Get post id.
     *
     * @return string
     */
    public function getPostId();

    /**
     * Set user id.
     *
     * @param $userId
     *
     * @return mixed
     */
    public function setUserId($userId);

    /**
     * Get user id.
     *
     * @return string
     */
    public function getUserId();

    /**
     * Set active.
     *
     * @param $active
     *
     * @return mixed
     */
    public function setActive($active);

    /**
     * Get active
     *
     * @return mixed
     */
    public function getActive();

    /**
     * Set created at.
     *
     * @param $date
     *
     * @return mixed
     */
    public function setCreatedAt($date);

    /**
     * Get created at.
     *
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * Set update at.
     *
     * @param $date
     *
     * @return mixed
     */
    public function setUpdatedAt($date);

    /**
     * Get update at.
     *
     * @return mixed
     */
    public function getUpdatedAt();
}
