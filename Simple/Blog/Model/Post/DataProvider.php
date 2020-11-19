<?php
declare(strict_types=1);

namespace Simple\Blog\Model\Post;

use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Simple\Blog\Helper\Data as DataHelper;

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
     * DataProvider constructor.
     *
     * @param                                         $name
     * @param                                         $primaryFieldName
     * @param                                         $requestFieldName
     * @param \Simple\Blog\Helper\Data                $dataHelper
     * @param \Magento\Framework\App\RequestInterface $request
     * @param array                                   $meta
     * @param array                                   $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        DataHelper $dataHelper,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->dataHelper = $dataHelper;
        $this->request = $request;
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
     * @return array
     */
    public function getData(): array
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
                $image[0]['url'] = $post->getImage();
                $post->setImage($image);
            }
            $this->loadedData[$post->getId()] = $post->getData();
        }

        return $this->loadedData;
    }
}
