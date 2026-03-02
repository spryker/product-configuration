<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductConfiguration\Expander;

use Generated\Shared\Transfer\ProductConfiguratorRequestDataTransfer;
use Spryker\Client\ProductConfiguration\Dependency\Client\ProductConfigurationToCurrencyClientInterface;

class ProductConfiguratorRequestDataCurrencyExpander implements ProductConfiguratorRequestDataExpanderInterface
{
    /**
     * @var \Spryker\Client\ProductConfiguration\Dependency\Client\ProductConfigurationToCurrencyClientInterface
     */
    protected $currencyClient;

    public function __construct(ProductConfigurationToCurrencyClientInterface $currencyClient)
    {
        $this->currencyClient = $currencyClient;
    }

    public function expand(ProductConfiguratorRequestDataTransfer $productConfiguratorRequestDataTransfer): ProductConfiguratorRequestDataTransfer
    {
        return $productConfiguratorRequestDataTransfer->setCurrencyCode(
            $this->currencyClient->getCurrent()->getCode(),
        );
    }
}
