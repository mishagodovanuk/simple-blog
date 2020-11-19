<?php

declare(strict_types=1);

namespace Simple\Blog\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Simple\Blog\Block\Adminhtml\AbstractButton;

/**
 * Class Delete
 *
 * @package Simple\Blog\Block\Adminhtml\Button
 */
class Delete extends AbstractButton implements ButtonProviderInterface
{
    /**
     * Get button data.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Delete'),
            'class' => 'delete',
            'on_click' => 'deleteConfirm(\'' . __(
                'Are you sure what you want to delete this post?'
            ) . '\', \'' . $this->getDeleteUrl() . '\')',
            'sort-order' => 20
        ];
    }

    /**
     * Get delete url.
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getPostId()]);
    }
}
