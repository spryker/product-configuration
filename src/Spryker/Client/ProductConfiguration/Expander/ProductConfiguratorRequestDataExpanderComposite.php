<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductConfiguration\Expander;

use Generated\Shared\Transfer\ProductConfiguratorRequestDataTransfer;

class ProductConfiguratorRequestDataExpanderComposite implements ProductConfiguratorRequestDataExpanderInterface
{
    /**
     * @var array<\Spryker\Client\ProductConfiguration\Expander\ProductConfiguratorRequestDataExpanderInterface>
     */
    protected $productConfiguratorRequestDataExpanders;

    /**
     * @param array<\Spryker\Client\ProductConfiguration\Expander\ProductConfiguratorRequestDataExpanderInterface> $productConfiguratorRequestDataExpanders
     */
    public function __construct(array $productConfiguratorRequestDataExpanders)
    {
        $this->productConfiguratorRequestDataExpanders = $productConfiguratorRequestDataExpanders;
    }

    public function expand(ProductConfiguratorRequestDataTransfer $productConfiguratorRequestDataTransfer): ProductConfiguratorRequestDataTransfer
    {
        foreach ($this->productConfiguratorRequestDataExpanders as $productConfiguratorRequestDataExpander) {
            $productConfiguratorRequestDataTransfer = $productConfiguratorRequestDataExpander->expand(
                $productConfiguratorRequestDataTransfer,
            );
        }

        return $productConfiguratorRequestDataTransfer;
    }
}
