<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductConfiguration\Validator;

use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\ProductConfiguratorResponseProcessorResponseTransfer;
use Generated\Shared\Transfer\ProductConfiguratorResponseTransfer;
use Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException;

class ProductConfiguratorMandatoryFieldsResponseValidator implements ProductConfiguratorResponseValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConfiguratorResponseProcessorResponseTransfer $productConfiguratorResponseProcessorResponseTransfer
     * @param array $configuratorResponseData
     *
     * @return \Generated\Shared\Transfer\ProductConfiguratorResponseProcessorResponseTransfer
     */
    public function validateProductConfiguratorCheckSumResponse(
        ProductConfiguratorResponseProcessorResponseTransfer $productConfiguratorResponseProcessorResponseTransfer,
        array $configuratorResponseData
    ): ProductConfiguratorResponseProcessorResponseTransfer {
        $productConfiguratorResponseProcessorResponseTransfer->requireProductConfiguratorResponse();

        $productConfiguratorResponseTransfer = $productConfiguratorResponseProcessorResponseTransfer
            ->getProductConfiguratorResponse();

        try {
            $this->assertMandatoryFields($productConfiguratorResponseTransfer);
        } catch (RequiredTransferPropertyException $requiredTransferPropertyException) {
            return $productConfiguratorResponseProcessorResponseTransfer->addMessage((new MessageTransfer())
                ->setMessage($requiredTransferPropertyException->getMessage()))
                ->setIsSuccessful(false);
        }

        return $productConfiguratorResponseProcessorResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConfiguratorResponseTransfer $productConfiguratorResponseTransfer
     *
     * @return void
     */
    protected function assertMandatoryFields(ProductConfiguratorResponseTransfer $productConfiguratorResponseTransfer): void
    {
        $productConfiguratorResponseTransfer
            ->requireSourceType()
            ->requireCheckSum()
            ->requireTimestamp()
            ->requireProductConfigurationInstance()
            ->getProductConfigurationInstance()
            ->requireConfiguratorKey();
    }
}
