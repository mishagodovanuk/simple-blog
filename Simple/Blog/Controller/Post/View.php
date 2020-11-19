<?php
declare(strict_types=1);

namespace Simple\Blog\Controller\Post;

use Magento\Framework\App\Action\Action as MagentoAction;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class View
 *
 * @package Simple\Blog\Controller\Post
 */
class View extends MagentoAction
{
    /**
     * Page factory.
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $pageFactory;

    /**
     * View constructor.
     *
     * @param \Magento\Framework\App\Action\Context      $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;

        parent::__construct($context);
    }

    /**
     * Execute.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute(): Page
    {
        return $this->pageFactory->create();
    }
}
