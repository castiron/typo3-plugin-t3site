<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

use \Castiron\CustomContent\Utility\CustomContentElementUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Register custom content element types for the backend. Sister call to register custom content elements
 * rendering is in ext_localconf.php
 */
CustomContentElementUtility::addCustomContentElementTypes($_EXTKEY);

// Remove a few types from the new page drag area: "Advanced", "Backend User Section", "Mountpoint", "Recycler"
ExtensionManagementUtility::addUserTSConfig(
    'options.pageTree.doktypesToShowInNewPageDragArea := removeFromList(2,6,7,255)'
);
