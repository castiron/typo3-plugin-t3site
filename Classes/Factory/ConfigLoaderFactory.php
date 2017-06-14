<?php namespace CIC\T3site\Factory;

use Helhum\ConfigLoader\ConfigurationLoader;
use Helhum\ConfigLoader\Processor\PlaceholderValue;
use Helhum\ConfigLoader\Reader\EnvironmentReader;
use Helhum\ConfigLoader\CachedConfigurationLoader;

/**
 * Credit goes to @helhum on Github for this:
 * https://github.com/helhum/TYPO3-Distribution/blob/master/src/ConfigLoaderFactory.php
 *
 * Class ConfigLoaderFactory
 */
class ConfigLoaderFactory
{
    /**
     * @param string $context
     * @param string $rootDir
     * @param array $additionalFileWatches
     * @param string $fixedCacheIdentifier
     * @return \Helhum\ConfigLoader\CachedConfigurationLoader
     */
    public static function buildLoader($context, $rootDir, $fixedCacheIdentifier = null, array $additionalFileWatches = []) {
        $cacheDir = $rootDir . '/var/cache';
        if ($fixedCacheIdentifier) {
            // Freeze configuration with fixed identifier if requested
            $cacheIdentifier = $fixedCacheIdentifier;
        } else {
            $fileWatches = array_merge(
                [
                    $rootDir . '/Source/typo3conf/LocalConfiguration.php',
                    $rootDir . '/Source/typo3conf/AdditionalConfiguration.php',
                    $rootDir . '/Source/typo3conf/ext/t3site/Configuration/Local/AdditionalConfiguration.php',
                    $rootDir . '/.env',
                ],
                $additionalFileWatches
            );
            $cacheIdentifier = self::getCacheIdentifier($context, $fileWatches);
        }
        return new CachedConfigurationLoader
        (
            $cacheDir,
            $cacheIdentifier,
            function() {
                return new ConfigurationLoader(
                    [new EnvironmentReader('T3')],
                    [new PlaceholderValue()]
                );
            }
        );
    }

    /**
     * @param string $context
     * @param array $fileWatches
     * @return string
     */
    protected static function getCacheIdentifier($context, array $fileWatches = array())
    {
        $identifier = $context;
        foreach ($fileWatches as $fileWatch) {
            if (file_exists($fileWatch)) {
                $identifier .= filemtime($fileWatch);
            }
        }
        return md5($identifier);
    }
}
