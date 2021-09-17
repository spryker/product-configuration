<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductConfiguration\Dependency\Client;

class ProductConfigurationToPriceProductVolumeClientBridge implements ProductConfigurationToPriceProductVolumeClientInterface
{
    /**
     * @var \Spryker\Client\PriceProductVolume\PriceProductVolumeClientInterface
     */
    protected $priceProductVolumeClient;

    /**
     * @param \Spryker\Client\PriceProductVolume\PriceProductVolumeClientInterface $priceProductVolumeClient
     */
    public function __construct($priceProductVolumeClient)
    {
        $this->priceProductVolumeClient = $priceProductVolumeClient;
    }

    /**
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function extractProductPricesForProductAbstract(array $priceProductTransfers): array
    {
        return $this->priceProductVolumeClient->extractProductPricesForProductAbstract($priceProductTransfers);
    }
}
