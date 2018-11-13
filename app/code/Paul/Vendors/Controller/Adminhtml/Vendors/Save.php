<?php

namespace Paul\Vendors\Controller\Adminhtml\Vendors;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException as FrameworkException;

class Save extends Action
{
    /**
     * @var \Paul\Vendors\Model\Vendors
     */
    protected $_model;
    protected $uploaderFactory;
    protected $imageModel;

    /**
     * @param Action\Context $context
     * @param \Paul\Vendors\Model\Vendors $model
     * @param  \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory
     * @param  \Paul\Vendors\Model\Vendors\Image $imageModel
     */
    public function __construct(
        Action\Context $context,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Paul\Vendors\Model\Vendors\Image $imageModel,
        \Paul\Vendors\Model\Vendors $model
    )
    {
        parent::__construct($context);
        $this->uploaderFactory = $uploaderFactory;
        $this->imageModel = $imageModel;
        $this->_model = $model;
    }

    public function uploadFileAndGetName($input, $destinationFolder, $data)
    {
        try {
            if (isset($data[$input]['delete'])) {
                return '';
            } else {
                $uploader = $this->uploaderFactory->create(['fileId' => $input]);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                $uploader->setAllowCreateFolders(true);
                $result = $uploader->save($destinationFolder);
                return $result['file'];
            }
        } catch (\Exception $e) {
            if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
                throw new FrameworkException($e->getMessage());
            } else {
                if (isset($data[$input]['value'])) {
                    return $data[$input]['value'];
                }
            }
        }
        return '';
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Paul_Vendors::vendors_save');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Paul\Vendors\Model\Vendors $model */
            $model = $this->_model;

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }

            if (isset($data['logo']['value'])) {
                $data['logo'] = $data['logo']['value'];
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'vendors_vendors_prepare_save',
                ['vendors' => $model, 'request' => $this->getRequest()]
            );

            $imageName = $this->uploadFileAndGetName('logo', $this->imageModel->getBaseDir(), $data);
            $model->setData('logo', $imageName);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('Vendors saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the vendors'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}