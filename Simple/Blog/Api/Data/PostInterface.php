<?php

namespace Simple\Blog\Api\Data;

/**
 * Interface PostInterface
 *
 * @package Simple\Blog\Api\Data
 */
interface PostInterface
{
    /**
     *
     */
    const TABLE_NAME = 'simple_blog_post';

    /**#@+
     * Constants defined for keys of data array.
     */
    const ID = 'entity_id';
    const TITLE = 'title';
    const TEXT = 'text';
    const IMAGE = 'image';
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
     * Set title.
     *
     * @param string $title
     *
     * @return mixed
     */
    public function setTitle(string $title);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();

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
     * Set image.
     *
     * @param string $image
     *
     * @return mixed
     */
    public function setImage(string $image);

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage();

    /**
     * Set active.
     *
     * @param $active
     *
     * @return mixed
     */
    public function setActive($active);

    /**
     * Get active.
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
     * Set updated at.
     *
     * @param $date
     *
     * @return mixed
     */
    public function setUpdatedAt($date);

    /**
     * Get updated at.
     *
     * @return mixed
     */
    public function getUpdatedAt();
}
