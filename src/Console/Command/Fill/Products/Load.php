<?php
/**
 *
 */
namespace Praxigento\Mage2Theme\Console\Command\Fill\Products;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\ObjectManagerInterface;
use Magento\CatalogInventory\Api\Data\StockInterface;
use Magento\CatalogInventory\Api\Data\StockItemInterface;
use Magento\CatalogInventory\Api\StockItemRepositoryInterface;
use Magento\CatalogInventory\Api\StockRepositoryInterface;

class Load
{
    const STOCK_ID = 1;
    /** @var  \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_conn;
    /** @var  \Psr\Log\LoggerInterface */
    protected $_logger;
    /** @var  ObjectManagerInterface */
    protected $_manObj;
    /** @var \Mage_Core_Model_Resource|\Magento\Framework\App\ResourceConnection */
    protected $_resource;
    /** @var  \Magento\CatalogInventory\Api\StockRepositoryInterface */
    private $_repoMageStock;
    /** @var  \Magento\CatalogInventory\Api\StockItemRepositoryInterface */
    private $_repoMageStockItem;

    public function __construct()
    {
        $this->_manObj = ObjectManager::getInstance();
        $this->_logger = $this->_manObj->get(\Psr\Log\LoggerInterface::class);
        $this->_resource = $this->_manObj->get(\Magento\Framework\App\ResourceConnection::class);
        $this->_conn = $this->_resource->getConnection();
        $this->_repoMageStock = $this->_manObj->get(StockRepositoryInterface::class);
        $this->_repoMageStockItem = $this->_manObj->get(StockItemRepositoryInterface::class);
    }

    public function execute()
    {
        $this->_logger->debug('Load data for magento theme begin.');
        $this->_conn->beginTransaction();
        try {
            /*
            * A Dishes
            */
            $catId = $this->_createMageCategory('Dishes');
            /* A Cup */
            $prodId = $this->_createMageProduct($catId, 'sku001', 'Cup', 12.35);
            /* create stock items */
            $stockItemId = $this->_createMageStockItem($prodId);
            /* add qtys to products */
            $this->_createQty($stockItemId, 250);

            /* A Plate */
            $prodId = $this->_createMageProduct($catId, 'sku002', 'Plate', 15.07);
            /* create stock items */
            $stockItemId = $this->_createMageStockItem($prodId);
            /* add qtys to products */
            $this->_createQty($stockItemId, 350);

            /* A Saucer */
            $prodId = $this->_createMageProduct($catId, 'sku003', 'Saucer', 7.18);
            /* create stock items */
            $stockItemId = $this->_createMageStockItem($prodId);
            /* add qtys to products */
            $this->_createQty($stockItemId, 50);


            /*
            * Furniture
            */
            $catId = $this->_createMageCategory('Furniture');
            /* A Table */
            $prodId = $this->_createMageProduct($catId, 'sku101', 'Table', 350);
            /* create stock items */
            $stockItemId = $this->_createMageStockItem($prodId);
            /* add qtys to products */
            $this->_createQty($stockItemId, 5000);

            /* A Chair */
            $prodId = $this->_createMageProduct($catId, 'sku102', 'Chair', 150);
            /* create stock items */
            $stockItemId = $this->_createMageStockItem($prodId);
            /* add qtys to products */
            $this->_createQty($stockItemId, 10000);

            /* A cupboard */
            $prodId = $this->_createMageProduct($catId, 'sku103', 'cupboard', 500);
            /* create stock items */
            $stockItemId = $this->_createMageStockItem($prodId);
            /* add qtys to products */
            $this->_createQty($stockItemId, 3500);
        } finally {
            $this->_conn->commit();
            //$this->_conn->rollBack();
        }
        $this->_logger->debug('Load data for magento theme end.');
    }

    private function _createMageCategory($name)
    {
        /**
         * Initialize factories using Object Manager.
         */
        /** @var  $categoryFactory \Magento\Catalog\Api\CategoryRepositoryInterface */
        $categoryFactory = $this->_manObj->get(\Magento\Catalog\Api\CategoryRepositoryInterface::class);
        /** @var  $category \Magento\Catalog\Api\Data\CategoryInterface */
        $category = $this->_manObj->create(\Magento\Catalog\Api\Data\CategoryInterface::class);
        $category->setName($name);
        $category->setIsActive(true);
        $saved = $categoryFactory->save($category);
        $result = $saved->getId();
        return $result;
    }

    /**
     * @param int $catId category ID
     * @param string $sku
     *
     * @return int ID of the new entity
     */
    private function _createMageProduct($catId, $sku, $name, $price)
    {
        /**
         * Initialize factories using Object Manager.
         */
        /** @var  $entityTypeFactory \Magento\Eav\Model\Entity\TypeFactory */
        $entityTypeFactory = $this->_manObj->get(\Magento\Eav\Model\Entity\TypeFactory::class);
        /** @var  $attrSetFactory \Magento\Eav\Model\Entity\Attribute\SetFactory */
        $attrSetFactory = $this->_manObj->get(\Magento\Eav\Model\Entity\Attribute\SetFactory::class);
        /** @var  $catProdLinkFactory \Magento\Catalog\Model\CategoryLinkRepository */
        $catProdLinkFactory = $this->_manObj->get(\Magento\Catalog\Model\CategoryLinkRepository::class);
        /** @var  $productFactory \Magento\Catalog\Api\ProductRepositoryInterface */
        $productFactory = $this->_manObj->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);
        /**
         * Retrieve entity type ID & attribute set ID.
         */
        /** @var  $entityType \Magento\Eav\Model\Entity\Type */
        $entityType = $entityTypeFactory
            ->create()
            ->loadByCode(\Magento\Catalog\Model\Product::ENTITY);
        $entityTypeId = $entityType->getId();
        $attrSet = $attrSetFactory
            ->create()
            ->load($entityTypeId, \Magento\Eav\Model\Entity\Attribute\Set::KEY_ENTITY_TYPE_ID);
        $attrSetId = $attrSet->getId();
        /**
         * Create simple product.
         */
        /** @var  $product \Magento\Catalog\Api\Data\ProductInterface */
        $product = $this->_manObj->create(\Magento\Catalog\Api\Data\ProductInterface::class);
        $product->setSku($sku);
        $product->setName($name);
        $product->setPrice($price);
        $product->setAttributeSetId($attrSetId);
        $product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE);
        $saved = $productFactory->save($product);
        /* link product with category */
        /** @var  $catProdLink \Magento\Catalog\Api\Data\CategoryProductLinkInterface */
        $catProdLink = $this->_manObj->create(\Magento\Catalog\Api\Data\CategoryProductLinkInterface::class);
        $catProdLink->setCategoryId($catId);
        $catProdLink->setSku($sku);
        $catProdLink->setPosition(1);
        $catProdLinkFactory->save($catProdLink);
        /* return product ID */
        $result = $saved->getId();
        return $result;
    }


    private function _createMageStockItem($prodId)
    {
        /* check if stock item already exist */
        /** @var  $criteria \Magento\CatalogInventory\Api\StockItemCriteriaInterface */
        $criteria = $this->_manObj->create(\Magento\CatalogInventory\Api\StockItemCriteriaInterface::class);
        $criteria->addFilter('byProduct', StockItemInterface::PRODUCT_ID, $prodId);
        $list = $this->_repoMageStockItem->getList($criteria);
        $items = $list->getItems();
        /** @var  $stockItem StockItemInterface */
        if (count($items)) {
            $stockItem = reset($items);
            $result = $stockItem->getItemId();
        } else {
            $stockItem = $this->_manObj->create(StockItemInterface::class);
            $stockItem->setStockId(self::STOCK_ID);
            $stockItem->setProductId($prodId);
            $saved = $this->_repoMageStockItem->save($stockItem);
            $result = $saved->getItemId();
        }
        return $result;
    }

    private function _createQty($stockItemId, $total)
    {
        /* update qty of the stock item */
        $stockItem = $this->_repoMageStockItem->get($stockItemId);
        $qty = $stockItem->getQty();
        $qty += $total;
        $stockItem->setQty($qty);
        $stockItem->setIsInStock(true);
        $this->_repoMageStockItem->save($stockItem);
    }
}