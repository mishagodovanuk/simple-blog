<?php

declare(strict_types=1);

namespace Simple\Blog\Model\Post\Image;

use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Uploader
 *
 * @package Simple\Blog\Model\Post\Image
 */
class Uploader extends ImageUploader
{
    /**
     * Image file path.
     */
    const FILE_PATH = 'simple_blog/image/post';

    /**
     * Allowed mime types
     *
     * @var array
     */
    protected $allowedMimeTypes;

    /**
     * Uploader factory
     *
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * Original file name
     *
     * @var string
     */
    protected $originalFileName = null;

    /**
     * Uploader constructor.
     *
     * @param \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase
     * @param \Magento\Framework\Filesystem                      $filesystem
     * @param \Magento\MediaStorage\Model\File\UploaderFactory   $uploaderFactory
     * @param \Magento\Store\Model\StoreManagerInterface         $storeManager
     * @param \Psr\Log\LoggerInterface                           $logger
     * @param                                                    $baseTmpPath
     * @param                                                    $basePath
     * @param array                                              $allowedExtensions
     * @param array                                              $allowedMimeTypes
     */
    public function __construct(
        Database $coreFileStorageDatabase,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        $baseTmpPath,
        $basePath,
        array $allowedExtensions = [],
        array $allowedMimeTypes = []
    ) {
        parent::__construct(
            $coreFileStorageDatabase,
            $filesystem,
            $uploaderFactory,
            $storeManager,
            $logger,
            $baseTmpPath,
            $basePath,
            $allowedExtensions
        );
        $this->uploaderFactory = $uploaderFactory;
        $this->allowedMimeTypes = $allowedMimeTypes;
    }

    /**
     * Save file tmp dir.
     *
     * @param string|int $fileId
     *
     * @return array|bool|string[]
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function saveFileToTmpDir($fileId)
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $uploader->setAllowRenameFiles(true);
        if (!$uploader->checkMimeType($this->allowedMimeTypes)) {
            throw new LocalizedException(__('File validation failed.'));
        }
        $fileName = null;
        if ($this->getOriginalFileName()) {
            $originalFileName = $this->getOriginalFileName();
            $discretionPath = $uploader->getDispretionPath($originalFileName);
            $baseTmpPath = static::FILE_PATH . $discretionPath;
        }
        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($baseTmpPath), $fileName);
        unset($result['path']);
        if (!$result) {
            throw new LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }
        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        /** @var \Magento\Store\Model\Store $store */
        $store = $this->storeManager->getStore();
        $result['url'] = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
            . $this->getFilePath($baseTmpPath, $result['file']);
        $result['name'] = $result['file'];
        if (isset($result['file'])) {
            try {
                $relativePath = rtrim($baseTmpPath, '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (\Exception $e) {
                $this->logger->critical($e);
                throw new LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }

        return $result;
    }

    /**
     * Set origin filename.
     *
     * @param string $originalFileName
     */
    public function setOriginalFileName(string $originalFileName): void
    {
        $this->originalFileName = $originalFileName;
    }

    /**
     * Get original file name.
     *
     * @return string|null
     */
    protected function getOriginalFileName(): ?string
    {
        return $this->originalFileName;
    }
}
