<?php

declare(strict_types=1);

namespace Simple\Blog\Block\Adminhtml\Button;

use Simple\Blog\Block\Adminhtml\AbstractButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Back
 *
 * @package Simple\Blog\Block\Adminhtml\Button
 */
class Back extends AbstractButton implements ButtonProviderInterface
{
    /**
     * Get button data.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort-order' => 10
        ];
    }

    /**
     * Get back url.
     *
     * @return string
     */
    protected function getBackUrl(): string
    {
        return $this->getUrl('*/*/');
    }
}
