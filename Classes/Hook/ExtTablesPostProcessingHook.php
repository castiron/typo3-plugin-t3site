<?php namespace CIC\T3site\Hook;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * For modifying the TCA after all extensions have been loaded.
 * For example, you might want to modify the TCA associated with an extension that hasn't been loaded yet.
 * Not foolproof, in case a different extension uses this hook too, and is included after t3site, but better than nothing!
 *
 */
class ExtTablesPostProcessingHook implements \TYPO3\CMS\Core\Database\TableConfigurationPostProcessingHookInterface {
    /**
     * Function which may process data created / registered by extTables
     * scripts (f.e. modifying TCA data of all extensions)
     *
     * @return void
     */
    public function processData() {
        if (ExtensionManagementUtility::isLoaded('news')) {
            $this->modifyNewsTca();
        }

        if (ExtensionManagementUtility::isLoaded('seo_basics')) {
            $this->modifySeoBasicsTca();
        }
    }

    /**
     * Modify TCA so that start/stop times display hours
     *
     * @return void
     */
    protected function modifyNewsTca() {
        $mods = array(
            'eval' => 'datetime',
            'size' => '13',
        );

        $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['starttime']['config'] =
            array_merge($GLOBALS['TCA']['tx_news_domain_model_news']['columns']['starttime']['config'], $mods);

        $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['endtime']['config'] =
            array_merge($GLOBALS['TCA']['tx_news_domain_model_news']['columns']['endtime']['config'], $mods);
    }

    /**
     * SEO Title tag should allow more characters than the default 70
     */
    protected function modifySeoBasicsTca() {
        $GLOBALS['TCA']['pages']['columns']['tx_seo_titletag']['config']['max'] = 512;
    }

}
