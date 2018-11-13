<?php

namespace Bars\Blog\Block;

class PostView extends \Magento\Framework\View\Element\Template implements
    \Magento\Framework\DataObject\IdentityInterface
{

    /**
     * Construct
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Bars\Blog\Model\Post $post
     * @param \Bars\Blog\Model\PostFactory $postFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Bars\Blog\Model\Post $post,
        \Bars\Blog\Model\PostFactory $postFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_post = $post;
        $this->_postFactory = $postFactory;
    }

    /**
     * @return \Bars\Blog\Model\Post
     */
    public function getPost()
    {
        if (!$this->hasData('post')) {
            if ($this->getPostId()) {
                /** @var \Bars\Blog\Model\Post $page */
                $post = $this->_postFactory->create();
            } else {
                $post = $this->_post;
            }
            $this->setData('post', $post);
        }
        return $this->getData('post');
    }

    /**
     * Return identifiers for produced content
     * @return array
     */
    public function getIdentities()
    {
        return [\Bars\Blog\Model\Post::CACHE_TAG . '_' . $this->getPost()->getId()];
    }

}
