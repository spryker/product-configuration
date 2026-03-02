<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Service\ProductConfiguration\HashGenerator;

use Generated\Shared\Transfer\ProductConfigurationInstanceTransfer;

interface ProductConfigurationInstanceHashGeneratorInterface
{
    public function getProductConfigurationInstanceHash(ProductConfigurationInstanceTransfer $productConfigurationInstanceTransfer): string;
}
