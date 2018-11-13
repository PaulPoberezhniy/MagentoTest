<?php namespace Bars\Blog\Helper;

use Magento\Framework\App\Action\Action;

class Post extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Bars\Blog\Model\Post
     */
    protected $_post;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Bars\Blog\Model\Post $post
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Bars\Blog\Model\Post $post,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->_post = $post;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Return a blog post from given post id.
     * @param Action $action
     * @param null $postId
     * @return \Magento\Framework\View\Result\Page|bool
     */
    public function prepareResultPost(Action $action, $postId = null)
    {
        if ($postId !== null && $postId !== $this->_post->getId()) {
            $delimiterPosition = strrpos($postId, '|');
            if ($delimiterPosition) {
                $postId = substr($postId, 0, $delimiterPosition);
            }

            if (!$this->_post->load($postId)) {
                return false;
            }
        }

        if (!$this->_post->getId()) {
            return false;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addHandle('blog_post_view');

        $resultPage->addPageLayoutHandles(['id' => $this->_post->getId()]);

        $this->_eventManager->dispatch(
            'bars_blog_post_render',
            ['post' => $this->_post, 'controller_action' => $action]
        );

        return $resultPage;
    }
}
