<?php
declare(strict_types=1);

namespace Simple\Blog\Block\Frontend\Catalog;

use Magento\Framework\View\Element\Template;
use Simple\Blog\Model\PostRepository;
use Magento\Catalog\Helper\Image as ImageHelper;

/**
 * Class PostView
 *
 * @package Simple\Blog\Block\Frontend\Catalog
 */
class PostView extends Template
{
    /**
     * Post repository.
     *
     * @var \Simple\Blog\Model\PostRepository
     */
    protected $postRepository;

    /**
     * Image helper.
     *
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * Post.
     *
     * @var
     */
    protected $post;

    /**
     * PostView constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Helper\Image                    $imageHelper
     * @param \Simple\Blog\Model\PostRepository                $postRepository
     * @param array                                            $data
     */
    public function __construct(
        Template\Context $context,
        ImageHelper $imageHelper,
        PostRepository $postRepository,
        array $data = []
    ) {
        $this->imageHelper = $imageHelper;
        $this->postRepository = $postRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get post.
     *
     * @return mixed|\Simple\Blog\Model\Post
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPost()
    {
        if ($this->post == null) {
            $this->post = $this->postRepository->getById($this->_request->getParam('id'));
        }

        return $this->post;
    }

    /**
     * Get image url.
     *
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageHelper->getPlaceholder();
    }
}
