<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Service\ProductConfiguration\Filter;

use Generated\Shared\Transfer\PriceProductFilterTransfer;

interface PriceProductConfigurationFilterInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     * @param \Generated\Shared\Transfer\PriceProductFilterTransfer $priceProductFilterTransfer
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function filterProductConfigurationPrices(
        array $priceProductTransfers,
        PriceProductFilterTransfer $priceProductFilterTransfer
    ): array;
}
