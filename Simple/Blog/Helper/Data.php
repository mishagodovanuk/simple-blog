<?php

declare(strict_types=1);

namespace Simple\Blog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Simple\Blog\Model\Post;

/**
 * Class Data
 *
 * @package Simple\Blog\Helper
 */
class Data extends AbstractHelper
{
    /**
     * Data persistor.
     *
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context                 $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Set admin edit product.
     *
     * @param \Simple\Blog\Model\Post $post
     */
    public function setAdminEditProduct(Post $post): void
    {
        $this->dataPersistor->set(Config::ADMIN_POST_PERSISTOR . $post->getId(), $post);
    }

    /**
     * Get admin edit product.
     *
     * @param string $id
     *
     * @return \Simple\Blog\Model\Post
     */
    public function getAdminEditProduct(string $id):  Post
    {
        $result = $this->dataPersistor->get(Config::ADMIN_POST_PERSISTOR . $id);
        $this->dataPersistor->clear(Config::ADMIN_POST_PERSISTOR . $id);

        return $result;
    }
}
