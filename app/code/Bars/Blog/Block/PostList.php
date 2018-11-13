<?php

namespace Bars\Blog\Block;

use Bars\Blog\Api\Data\PostInterface;
use Bars\Blog\Model\ResourceModel\Post\Collection as PostCollection;

class PostList extends \Magento\Framework\View\Element\Template implements
    \Magento\Framework\DataObject\IdentityInterface
{
    /**
     * @var \Bars\Blog\Model\ResourceModel\Post\CollectionFactory
     */
    protected $_postCollectionFactory;

    /**
     * Construct
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Bars\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory ,
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Bars\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_postCollectionFactory = $postCollectionFactory;
    }

    /**
     * @return \Bars\Blog\Model\ResourceModel\Post\Collection
     */
    public function getPosts()
    {
        if (!$this->hasData('posts')) {
            $posts = $this->_postCollectionFactory
                ->create()
                ->addFilter('is_active', 1)
                ->addOrder(
                    PostInterface::CREATION_TIME,
                    PostCollection::SORT_ORDER_DESC
                );
            $this->setData('posts', $posts);
        }
        return $this->getData('posts');
    }

    /**
     * Return identifiers for produced content
     * @return array
     */
    public function getIdentities()
    {
        return [\Bars\Blog\Model\Post::CACHE_TAG . '_' . 'list'];
    }

}
