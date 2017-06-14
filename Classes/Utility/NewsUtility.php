<?php namespace CIC\T3site\Utility;

use Castiron\Databaseable\Traits\Databaseable;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Class NewsTemplateLayoutUtility
 * @package CIC\T3site\Utility
 */
class NewsUtility {
    use Databaseable;

    /**
     * @param $label
     * @param $key
     */
    public static function addTemplateLayout($label, $key) {
        static::initTemplateConfig();
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['templateLayouts'][] = [$label, $key];
    }

    /**
     * @param string $select Comma list of fields to select
     * @return string
     */
    public static function currentNewsRecord($select = 'title') {
        /**
         * Bail if news isn't installed!
         */
        if (!ExtensionManagementUtility::isLoaded('news')) {
            return [];
        }

        /**
         * Bail if there's no news record
         */
        if (!MathUtility::canBeInterpretedAsInteger($GLOBALS['HTTP_GET_VARS']['tx_news_pi1']['news'])) {
            return [];
        }

        /**
         *
         */
        $newsUid = intval($GLOBALS['HTTP_GET_VARS']['tx_news_pi1']['news']);
        $result = static::queryBuilderForTable('tx_news_domain_model_news')
            ->select($select)
            ->from('tx_news_domain_model_news')
            ->where('uid=' . $newsUid)
            ->execute()
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $result ?: [];
    }

    /**
     *
     */
    protected static function initTemplateConfig() {
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['templateLayouts'])) {
            return;
        }

        $GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['templateLayouts'] = [];
    }
}
