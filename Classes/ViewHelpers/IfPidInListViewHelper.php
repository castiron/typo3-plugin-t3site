<?php namespace CIC\T3site\ViewHelpers;

use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *	Returns true if the supplied pid is in the supplied comma-separated string of whitelisted pids
 *  e.g.:
 *  <t:ifPidInList pid="{category.parent}" whitelist="{settings.pid.granteeTabsParentCategory}">
 */

class IfPidInListViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper {
    /**
     * @param $pid
     * @param $whitelist
     * @return mixed|string
     */
    public function render($pid, $whitelist) {
        $pids = GeneralUtility::trimExplode(',', $pid);
        $whitelistedPids = GeneralUtility::trimExplode(',', $whitelist);

        foreach ($pids as $key => $pidValue) {
            if(!in_array($pidValue, $whitelistedPids)) return $this->renderElseChild();
        }

        return $this->renderThenChild();
    }
}
