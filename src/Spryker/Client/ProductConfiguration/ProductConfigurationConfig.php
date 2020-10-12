<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductConfiguration;

use Spryker\Client\Kernel\AbstractBundleConfig;
use Spryker\Shared\ProductConfiguration\ProductConfigurationConfig as ProductConfigurationProductConfigurationConfig;

class ProductConfigurationConfig extends AbstractBundleConfig
{
    /**
     * Number of seconds while response considered as valid
     */
    protected const PRODUCT_CONFIGURATION_RESPONSE_MAX_VALID_SECONDS = 60;

    /**
     * @api
     *
     * @return string
     */
    public function getProductConfigurationEncryptionKey(): string
    {
        return $this->get(ProductConfigurationProductConfigurationConfig::SPRYKER_CONFIGURATOR_ENCRYPTION_KEY);
    }

    /**
     * @api
     *
     * @return int
     */
    public function getProductConfigurationResponseMaxValidSeconds(): int
    {
        return static::PRODUCT_CONFIGURATION_RESPONSE_MAX_VALID_SECONDS;
    }
}
