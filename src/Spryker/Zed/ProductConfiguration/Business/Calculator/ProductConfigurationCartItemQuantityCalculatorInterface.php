<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductConfiguration\Business\Calculator;

use Generated\Shared\Transfer\CartItemQuantityTransfer;
use Generated\Shared\Transfer\ItemTransfer;

interface ProductConfigurationCartItemQuantityCalculatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer[] $itemsInCart
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\CartItemQuantityTransfer
     */
    public function calculateCartItemQuantity(array $itemsInCart, ItemTransfer $itemTransfer): CartItemQuantityTransfer;
}
