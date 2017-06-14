<?php namespace CIC\T3site\ViewHelpers;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Utility\MathUtility;


/**
 *	Returns true if the doktype key matches the integer that's passed in.
 *
 */

class IfDokTypeInList extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper {

    /**
     * @param integer $doktype
     * @return boolean|null
     */
    public function render($doktype) {
        $doktypes = GeneralUtility::trimExplode(',', $doktype);
        foreach ($doktypes as $key => $type) {
            if(!MathUtility::canBeInterpretedAsInteger($type)) {
                $constName = '\CIC\T3site\Service\DokType::DOKTYPE_'.strtoupper($type);
                if(defined($constName)) {
                    $doktypes[$key] = constant($constName);
                }
            }
        }


        return in_array($GLOBALS['TSFE']->page['doktype'], $doktypes) ?
            $this->renderThenChild() :
            $this->renderElseChild();
    }
}
