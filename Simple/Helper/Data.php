<?php
declare(strict_types=1);
namespace Simple\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Simple\Helper\Config;
use Simple\Blog\Model\Post;

class Data extends AbstractHelper
{
    protected $dataPersistor;

    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
    }

    public function setAdminEditProduct(Post $post): void
    {
        $this->dataPersistor->set(Config::ADMIN_POST_PERSISTOR . $post->getId(), $post);
    }

    public function getAdminEditProduct(string $id = null)
    {
        return $this->dataPersistor->get(Config::ADMIN_POST_PERSISTOR . $id);
    }

}
