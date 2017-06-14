<?php

/**
 * This little gem is needed to make PHP throw a 500 response code when there is an error that TYPO3 doesn't catch :|
 * Please see https://bugs.php.net/bug.php?id=50921 for more information
 */
if (php_sapi_name() !== 'cli') {
    register_shutdown_function(function() {
        $error = error_get_last();
        if ($error['type'] == E_ERROR) {
            header('HTTP/1.1 500 Internal Server Error');
        }
    });
}

define('PATH_root', dirname(PATH_site));

/**
 * Load config with automatic overlay from .env
 */
$configLoader = \CIC\T3site\Factory\ConfigLoaderFactory::buildLoader(
    $context =
        \TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->isProduction() ? 'production' : 'development',
    $rootDir = PATH_root,
    $fixedCacheIdentifier = getenv('TYPO3_CONTEXT') === 'Production' ? 't3site' : null
);
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
    $GLOBALS['TYPO3_CONF_VARS'],
    $configLoader->load()
);

/**
 * Initialize Error Handling.
 * This is a true case where we want to do this _after_ the rest of the config
 */
require_once(PATH_site . 'typo3conf/ext/rollbar/Classes/Utility/Initializer.php');
\CIC\Rollbar\Utility\Initializer::initErrorHandling();
