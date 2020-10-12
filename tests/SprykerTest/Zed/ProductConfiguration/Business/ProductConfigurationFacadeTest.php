<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductConfiguration\Business;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\ItemBuilder;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConfigurationFilterTransfer;
use Generated\Shared\Transfer\ProductConfigurationInstanceTransfer;
use Generated\Shared\Transfer\ProductConfigurationTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductConfiguration
 * @group Business
 * @group Facade
 * @group ProductConfigurationFacadeTest
 * Add your own group annotations below this line
 */
class ProductConfigurationFacadeTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\ProductConfiguration\ProductConfigurationBusinessTester
     */
    protected $tester;

    protected const TEST_GROUP_KEY = 'test_group_key';
    protected const TEST_PRODUCT_CONFIGURATION_ARRAY = ['test_group_key'];
    protected const TEST_PRODUCT_CONFIGURATION_HASH = '0146dbdb9eb9a1d17dc66478f869f556';

    /**
     * @return void
     */
    public function testGetProductConfigurationCollectionRetrievesCollection(): void
    {
        //Arrange
        $productTransfer = $this->tester->haveProduct();

        $productConfigurationTransfer = $this->tester->haveProductConfiguration(
            [
                ProductConfigurationTransfer::FK_PRODUCT => $productTransfer->getIdProductConcrete(),
            ]
        );

        $productConfigurationCriteriaTransfer = (new ProductConfigurationFilterTransfer())
            ->setProductConfigurationIds([$productConfigurationTransfer->getIdProductConfiguration()]);

        //Act
        $productConfigurationCollectionTransfer = $this->tester->getFacade()
            ->getProductConfigurationCollection($productConfigurationCriteriaTransfer);

        /** @var \Generated\Shared\Transfer\ProductConfigurationTransfer $createdProductConfigurationTransfer */
        $createdProductConfigurationTransfer = $productConfigurationCollectionTransfer->getProductConfigurations()
            ->getIterator()->current();

        //Assert
        $this->assertNotEmpty($productConfigurationCollectionTransfer->getProductConfigurations());
        $this->assertSame($productTransfer->getIdProductConcrete(), $createdProductConfigurationTransfer->getFkProduct());
    }

    /**
     * @return void
     */
    public function testGetProductConfigurationCollectionWithWrongProductFkRetrievesEmptyCollection(): void
    {
        //Arrange
        $productConfigurationCriteriaTransfer = (new ProductConfigurationFilterTransfer())
            ->setProductConfigurationIds([ProductConfigurationTransfer::FK_PRODUCT => 222]);

        //Act
        $productConfigurationCollectionTransfer = $this->tester->getFacade()
            ->getProductConfigurationCollection($productConfigurationCriteriaTransfer);

        //Assert
        $this->assertEmpty($productConfigurationCollectionTransfer->getProductConfigurations());
    }

    /**
     * @return void
     */
    public function testExpandProductConfigurationItemsWithGroupKeyWillAddProductConfigurationHash(): void
    {
        //Arrange
        $productConfigurationInstanceMock = $this->getMockBuilder(ProductConfigurationInstanceTransfer::class)
            ->onlyMethods(['toArray'])
            ->getMock();

        $productConfigurationInstanceMock->method('toArray')->willReturn(static::TEST_PRODUCT_CONFIGURATION_ARRAY);

        $itemTransfer = (new ItemBuilder([
            ItemTransfer::GROUP_KEY => static::TEST_GROUP_KEY,
            ItemTransfer::PRODUCT_CONFIGURATION_INSTANCE => $productConfigurationInstanceMock,
        ]))->build();

        $cartChangeTransfer = (new CartChangeTransfer())->addItem($itemTransfer);

        $itemProductConfigurationGroupKey = sprintf(
            '%s-%s',
            $itemTransfer->getGroupKey(),
            static::TEST_PRODUCT_CONFIGURATION_HASH
        );

        //Act
        $expandedCartChangeTransfer = $this->tester->getFacade()
            ->expandProductConfigurationItemsWithGroupKey($cartChangeTransfer);

        /** @var \Generated\Shared\Transfer\ItemTransfer $expandedItemTransfer */
        $expandedItemTransfer = $expandedCartChangeTransfer->getItems()->getIterator()->current();

        //Assert
        $this->assertSame($itemProductConfigurationGroupKey, $expandedItemTransfer->getGroupKey());
    }

    /**
     * @return void
     */
    public function testExpandProductConfigurationItemsWithGroupKeyWithoutProductConfigurationDoNothing(): void
    {
        //Arrange
        $itemTransfer = (new ItemBuilder([
            ItemTransfer::GROUP_KEY => static::TEST_GROUP_KEY,
            ]))->build();

        $cartChangeTransfer = (new CartChangeTransfer())->addItem($itemTransfer);

        //Act
        $expandedCartChangeTransfer = $this->tester->getFacade()
            ->expandProductConfigurationItemsWithGroupKey($cartChangeTransfer);

        /** @var \Generated\Shared\Transfer\ItemTransfer $expandedItemTransfer */
        $expandedItemTransfer = $expandedCartChangeTransfer->getItems()->getIterator()->current();

        //Assert
        $this->assertSame(static::TEST_GROUP_KEY, $expandedItemTransfer->getGroupKey());
    }

    /**
     * @return void
     */
    public function testIsQuoteProductConfigurationValidWithValidProductConfiguration(): void
    {
        //Arrange
        $productConfigurationInstance = (new ProductConfigurationInstanceTransfer())->setIsComplete(true);

        $itemTransfer = (new ItemBuilder([
            ItemTransfer::GROUP_KEY => static::TEST_GROUP_KEY,
            ItemTransfer::PRODUCT_CONFIGURATION_INSTANCE => $productConfigurationInstance,
        ]))->build();

        $quoteTransfer = (new QuoteTransfer())->addItem($itemTransfer);

        //Act
        $isQuoteProductConfigurationValid = $this->tester->getFacade()
            ->isQuoteProductConfigurationValid($quoteTransfer, new CheckoutResponseTransfer());

        //Assert
        $this->assertTrue($isQuoteProductConfigurationValid);
    }

    /**
     * @return void
     */
    public function testIsQuoteProductConfigurationValidWithNotValidProductConfiguration(): void
    {
        //Arrange
        $productConfigurationInstance = (new ProductConfigurationInstanceTransfer())->setIsComplete(false);

        $itemTransfer = (new ItemBuilder([
            ItemTransfer::GROUP_KEY => static::TEST_GROUP_KEY,
            ItemTransfer::PRODUCT_CONFIGURATION_INSTANCE => $productConfigurationInstance,
        ]))->build();

        $quoteTransfer = (new QuoteTransfer())->addItem($itemTransfer);

        //Act
        $isQuoteProductConfigurationValid = $this->tester->getFacade()
            ->isQuoteProductConfigurationValid($quoteTransfer, new CheckoutResponseTransfer());

        //Assert
        $this->assertFalse($isQuoteProductConfigurationValid);
    }

    /**
     * @return void
     */
    public function testIsQuoteProductConfigurationValidWithoutProductConfigurationInstance(): void
    {
        //Arrange
        $itemTransfer = (new ItemBuilder([
            ItemTransfer::GROUP_KEY => static::TEST_GROUP_KEY,
        ]))->build();

        $quoteTransfer = (new QuoteTransfer())->addItem($itemTransfer);

        //Act
        $isQuoteProductConfigurationValid = $this->tester->getFacade()
            ->isQuoteProductConfigurationValid($quoteTransfer, new CheckoutResponseTransfer());

        //Assert
        $this->assertTrue($isQuoteProductConfigurationValid);
    }

    /**
     * @return void
     */
    public function testExpandPriceProductTransfersWithProductConfigurationPricesWillExpandPricesWithMerge(): void
    {
        //Arrange
        $productConfigurationInstanceMock = $this->getMockBuilder(ProductConfigurationInstanceTransfer::class)
            ->onlyMethods(['getPrices'])
            ->getMock();

        $priceProductTransfers = new ArrayObject();
        $priceProductTransfers->append((new PriceProductTransfer())->setSkuProduct('test1'));

        $productConfigurationInstanceMock->method('getPrices')->willReturn($priceProductTransfers);

        $itemTransfer = (new ItemBuilder([
            ItemTransfer::PRODUCT_CONFIGURATION_INSTANCE => $productConfigurationInstanceMock,
        ]))->build();

        $cartChangeTransfer = (new CartChangeTransfer())->addItem($itemTransfer);

        //Act
        $priceProductTransfersResult = $this->tester->getFacade()
            ->expandPriceProductTransfersWithProductConfigurationPrices(
                [(new PriceProductTransfer())->setSkuProduct('test2')],
                $cartChangeTransfer
            );

        //Assert
        $this->assertCount(2, $priceProductTransfersResult);
    }

    /**
     * @return void
     */
    public function testExpandPriceProductTransfersWithProductConfigurationPricesWillDoNothingWithoutProductConfigurationExistence(): void
    {
        //Arrange
        $itemTransfer = (new ItemBuilder())->build();

        $cartChangeTransfer = (new CartChangeTransfer())->addItem($itemTransfer);

        //Act
        $priceProductTransfersResult = $this->tester->getFacade()
            ->expandPriceProductTransfersWithProductConfigurationPrices(
                [(new PriceProductTransfer())->setSkuProduct('test2')],
                $cartChangeTransfer
            );

        //Assert
        $this->assertCount(1, $priceProductTransfersResult);
    }
}
