<?php

use \TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use \Castiron\CustomContent\Utility\CustomContentElementUtility;

/**
 * Gridelements via Extbase
 */
ExtensionUtility::configurePlugin(
    $_EXTKEY,
    'CIC.GridelementSupport',
    array(
        // Don't need anything in these, just the controller name (see typoscript)
        'Gridelements' => '',
    ),
    array()
);

/**
 * This registers custom content elements as per the above config. Sister call to register
 * the elements for the backend is in ext_tables.php
 */
CustomContentElementUtility::addCustomContentElements($_EXTKEY, 'CIC');

/**
 * Hook for assigning arbitrary stuff in frontend fluidpage templates
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['fluidpage:Tx_Fluidpage_Controller_Template']['viewAssignmentHooks'][] =
    'CIC\T3site\Hook\PageTemplateViewAssignment->getAssignments';

/**
 * Hook to modify TCA after all extensions have been loaded. This does a few minor things like ensure certain news
 * config is in place.
 */
$TYPO3_CONF_VARS['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing'][] =
    \CIC\T3site\Hook\ExtTablesPostProcessingHook::class;
