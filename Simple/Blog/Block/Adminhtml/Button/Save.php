<?php

declare(strict_types=1);

namespace Simple\Blog\Block\Adminhtml\Button;

use Simple\Blog\Block\Adminhtml\AbstractButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Save
 *
 * @package Simple\Blog\Block\Adminhtml\Button
 */
class Save extends AbstractButton implements ButtonProviderInterface
{
    /**
     * Get button data.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save Post'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'save']
                ],
                'form-role' => 'save'
            ],
            'sort_order' => 90,
        ];
    }
}
