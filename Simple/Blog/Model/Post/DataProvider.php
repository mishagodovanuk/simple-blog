<?php
declare(strict_types=1);

namespace Simple\Blog\Model\Post;

use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Simple\Blog\Helper\Data as DataHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Api\Filter;

/**
 * Class DataProvider
 *
 * @package Simple\Blog\Model\Post
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * Loaded data
     *
     * @var array
     */
    private $loadedData;

    /**
     * Data helper.
     *
     * @var \Simple\Blog\Helper\Data
     */
    protected $dataHelper;

    /**
     * Request interface.
     *
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * DataProvider constructor.
     *
     * @param string                                     $name
     * @param string                                     $primaryFieldName
     * @param string                                     $requestFieldName
     * @param \Simple\Blog\Helper\Data                   $dataHelper
     * @param \Magento\Framework\App\RequestInterface    $request
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array                                      $meta
     * @param array                                      $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        DataHelper $dataHelper,
        RequestInterface $request,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->dataHelper = $dataHelper;
        $this->request = $request;
        $this->storeManager = $storeManager;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

    /**
     * Get data.
     *
     * @return array|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData(): ?array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        //TODO Replace request by context or create simular function in datahelper.
        $data = $this->dataHelper->getAdminEditProduct($this->request->getParam('id'));

        if (!empty($data)) {
            $post = $data;
            if ($post->getImage()) {
                $image = [];
                $image[0]['name'] = basename($post->getImage());
                $image[0]['url'] = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $post->getImage();
                $post->setImage($image);
            }
            $this->loadedData[$post->getId()] = $post->getData();
        }

        return $this->loadedData;
    }

    //TODO find out posible cases of addfieldtofilter issues.

    /**
     * Add filter.
     *
     * @param \Magento\Framework\Api\Filter $filter
     *
     * @return mixed|void
     */
    public function addFilter(Filter $filter): void
    {
        if ($this->getCollection()) {
            $this->getCollection()->addFieldToFilter(
                $filter->getField(),
                [$filter->getConditionType() => $filter->getValue()]
            );
        }
    }
}
