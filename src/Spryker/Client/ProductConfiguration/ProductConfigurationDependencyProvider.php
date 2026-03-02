<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductConfiguration;

use GuzzleHttp\Client as GuzzleHttpClient;
use Spryker\ChecksumGenerator\Checksum\ChecksumGeneratorInterface;
use Spryker\ChecksumGenerator\Checksum\CrcOpenSslChecksumGenerator;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\ProductConfiguration\Dependency\Client\ProductConfigurationToCurrencyClientBridge;
use Spryker\Client\ProductConfiguration\Dependency\Client\ProductConfigurationToCustomerClientBridge;
use Spryker\Client\ProductConfiguration\Dependency\Client\ProductConfigurationToLocaleBridge;
use Spryker\Client\ProductConfiguration\Dependency\Client\ProductConfigurationToPriceClientBridge;
use Spryker\Client\ProductConfiguration\Dependency\Client\ProductConfigurationToPriceProductVolumeClientBridge;
use Spryker\Client\ProductConfiguration\Dependency\Client\ProductConfigurationToStoreClientBridge;
use Spryker\Client\ProductConfiguration\Dependency\External\ProductConfigurationToGuzzleHttpClientAdapter;
use Spryker\Client\ProductConfiguration\Dependency\External\ProductConfigurationToSprykerChecksumGeneratorAdapter;
use Spryker\Client\ProductConfiguration\Dependency\Service\ProductConfigurationToPriceProductServiceBridge;
use Spryker\Client\ProductConfiguration\Dependency\Service\ProductConfigurationToUtilEncodingServiceBridge;

/**
 * @method \Spryker\Client\ProductConfiguration\ProductConfigurationConfig getConfig()
 */
class ProductConfigurationDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';

    /**
     * @var string
     */
    public const CLIENT_STORE = 'CLIENT_STORE';

    /**
     * @var string
     */
    public const CLIENT_LOCALE = 'CLIENT_LOCALE';

    /**
     * @var string
     */
    public const CLIENT_PRICE = 'CLIENT_PRICE';

    /**
     * @var string
     */
    public const CLIENT_CURRENCY = 'CLIENT_CURRENCY';

    /**
     * @var string
     */
    public const CLIENT_HTTP = 'CLIENT_HTTP';

    /**
     * @var string
     */
    public const CLIENT_PRICE_PRODUCT_VOLUME = 'CLIENT_PRICE_PRODUCT_VOLUME';

    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @var string
     */
    public const SERVICE_PRODUCT_CONFIGURATION = 'SERVICE_PRODUCT_CONFIGURATION';

    /**
     * @var string
     */
    public const SERVICE_PRICE_PRODUCT = 'SERVICE_PRICE_PRODUCT';

    /**
     * @var string
     */
    public const PLUGINS_PRODUCT_CONFIGURATOR_REQUEST_EXPANDER = 'PLUGINS_PRODUCT_CONFIGURATOR_REQUEST_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_PRODUCT_CONFIGURATION_PRICE_EXTRACTOR = 'PLUGINS_PRODUCT_CONFIGURATION_PRICE_EXTRACTOR';

    /**
     * @var string
     */
    public const CHECKSUM_GENERATOR = 'CHECKSUM_GENERATOR';

    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        $container = $this->addCustomerClient($container);
        $container = $this->addStoreClient($container);
        $container = $this->addLocaleClient($container);
        $container = $this->addPriceClient($container);
        $container = $this->addCurrencyClient($container);
        $container = $this->addHttpClient($container);
        $container = $this->addUtilEncodingService($container);
        $container = $this->addProductConfigurationService($container);
        $container = $this->addPriceProductService($container);
        $container = $this->addPriceProductConfigurationPriceExtractorPlugins($container);
        $container = $this->addProductConfigurationRequestExpanderPlugins($container);
        $container = $this->addChecksumGenerator($container);
        $container = $this->addPriceProductVolumeClient($container);

        return $container;
    }

    protected function addPriceProductService(Container $container): Container
    {
        $container->set(static::SERVICE_PRICE_PRODUCT, function (Container $container) {
            return new ProductConfigurationToPriceProductServiceBridge(
                $container->getLocator()->priceProduct()->service(),
            );
        });

        return $container;
    }

    protected function addProductConfigurationService(Container $container): Container
    {
        $container->set(static::SERVICE_PRODUCT_CONFIGURATION, function (Container $container) {
            return $container->getLocator()->productConfiguration()->service();
        });

        return $container;
    }

    protected function addHttpClient(Container $container): Container
    {
        $container->set(static::CLIENT_HTTP, function () {
            return new ProductConfigurationToGuzzleHttpClientAdapter(
                new GuzzleHttpClient(),
            );
        });

        return $container;
    }

    protected function addCurrencyClient(Container $container): Container
    {
        $container->set(static::CLIENT_CURRENCY, function (Container $container) {
            return new ProductConfigurationToCurrencyClientBridge(
                $container->getLocator()->currency()->client(),
            );
        });

        return $container;
    }

    protected function addPriceClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRICE, function (Container $container) {
            return new ProductConfigurationToPriceClientBridge(
                $container->getLocator()->price()->client(),
            );
        });

        return $container;
    }

    protected function addLocaleClient(Container $container): Container
    {
        $container->set(static::CLIENT_LOCALE, function (Container $container) {
            return new ProductConfigurationToLocaleBridge(
                $container->getLocator()->locale()->client(),
            );
        });

        return $container;
    }

    protected function addCustomerClient(Container $container): Container
    {
        $container->set(static::CLIENT_CUSTOMER, function (Container $container) {
            return new ProductConfigurationToCustomerClientBridge(
                $container->getLocator()->customer()->client(),
            );
        });

        return $container;
    }

    protected function addStoreClient(Container $container): Container
    {
        $container->set(static::CLIENT_STORE, function (Container $container) {
            return new ProductConfigurationToStoreClientBridge(
                $container->getLocator()->store()->client(),
            );
        });

        return $container;
    }

    protected function addPriceProductVolumeClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRICE_PRODUCT_VOLUME, function (Container $container) {
            return new ProductConfigurationToPriceProductVolumeClientBridge(
                $container->getLocator()->priceProductVolume()->client(),
            );
        });

        return $container;
    }

    protected function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return new ProductConfigurationToUtilEncodingServiceBridge(
                $container->getLocator()->utilEncoding()->service(),
            );
        });

        return $container;
    }

    protected function addProductConfigurationRequestExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PRODUCT_CONFIGURATOR_REQUEST_EXPANDER, function () {
            return $this->getProductConfigurationRequestExpanderPlugins();
        });

        return $container;
    }

    protected function addChecksumGenerator(Container $container): Container
    {
        $container->set(static::CHECKSUM_GENERATOR, function () {
            return new ProductConfigurationToSprykerChecksumGeneratorAdapter(
                $this->getChecksumGenerator(),
            );
        });

        return $container;
    }

    protected function getChecksumGenerator(): ChecksumGeneratorInterface
    {
        return new CrcOpenSslChecksumGenerator(
            $this->getConfig()->getProductConfiguratorHexInitializationVector(),
        );
    }

    /**
     * @return array<\Spryker\Client\ProductConfigurationExtension\Dependency\Plugin\ProductConfiguratorRequestExpanderPluginInterface>
     */
    protected function getProductConfigurationRequestExpanderPlugins(): array
    {
        return [];
    }

    protected function addPriceProductConfigurationPriceExtractorPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PRODUCT_CONFIGURATION_PRICE_EXTRACTOR, function () {
            return $this->getProductConfigurationPriceExtractorPlugins();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Client\ProductConfigurationExtension\Dependency\Plugin\ProductConfigurationPriceExtractorPluginInterface>
     */
    protected function getProductConfigurationPriceExtractorPlugins(): array
    {
        return [];
    }
}
