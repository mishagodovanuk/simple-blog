<?php

namespace Simple\Blog\Model\Post\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Simple\Blog\Model\Post;

class Status implements OptionSourceInterface
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function toOptionArray()
    {
        $options = [];
        foreach ($this->post->getActiveStatuses() as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key
            ];
        }

        return $options;
    }
}
