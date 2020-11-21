<?php
declare(strict_types=1);

namespace Simple\Blog\Block\Adminhtml;

use Magento\Backend\Block\Widget\Context;

/**
 * Class AbstractButton
 *
 * @package Simple\Blog\Block\Adminhtml
 */
class AbstractButton
{
    /**
     * Context.
     *
     * @var \Magento\Backend\Block\Widget\Context
     */
    protected $context;

    /**
     * AbstractButton constructor.
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * Get post id.
     *
     * @return string
     */
    public function getPostId(): ?string
    {
        return $this->context->getRequest()->getParam('id');
    }

    /**
     * Get url.
     *
     * @param string     $route
     * @param array|null $params
     *
     * @return string
     */
    public function getUrl(string $route, array $params = null): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
