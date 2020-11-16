<?php

namespace Simple\Blog\Model\Post;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Model\UrlInterface;
use Simple\Blog\Model\ResourceModel\Post\CollectionFactory;
use Simple\Helper\Data as DataHelper;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var
     */
    protected $collection;

    /**
     * Loaded data
     *
     * @var array
     */
    private $loadedData;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    protected $dataHelper;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $PostCollectionFactory,
        StoreManagerInterface $storeManager,
        DataHelper $dataHelper,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $PostCollectionFactory->create();
        $this->storeManager = $storeManager;
        $this->dataHelper = $dataHelper;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

    /**
     * Get data
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $post) {
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $url = $mediaUrl . $post->getImage();
            $image[] = [
                'url'  => $url,
                'file' => basename($post->getImage())
            ];
            $post->setImage($image);

            $this->loadedData[$post->getId()] = $post->getData();
        }

        $data = $this->dataHelper->getAdminEditProduct()
        if (!empty($data)) {
            $post = $this->collection->getNewEmptyItem();
            $post->setData($data);
            $this->loadedData[$post->getId()] = $post->getData();
            $this->dataPersistor->clear('hodovanuk_blog_post');
        }

        return $this->loadedData;
    }
}
