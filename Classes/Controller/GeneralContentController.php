<?php
namespace CIC\T3site\Controller;

/**
 * Class GeneralContentController
 * @package CIC\T3site\Controller
 */
class GeneralContentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    var $cObj;

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction() {
        $this->cObj = $this->configurationManager->getContentObject();
    }

    /**
     * A simple custom content element that takes the content from a corresponding colPos on another page
     * and renders it.
     *
     * @return string
     */
    public function mirrorAction() {
        $out = '';
        $sourcePid = intval($this->settings['ffSourcePid']);
        if($sourcePid > 0) {
            $cObj = $this->configurationManager->getContentObject();
            $colPos = $cObj->data['colPos'];
            $ts = array();
            $ts['table'] = 'tt_content';
            $ts['select.']['pidInList'] = $sourcePid;
            $ts['select.']['orderBy'] = 'sorting';
            $ts['select.']['where'] = 'colPos=' . $colPos;
            $out .= $cObj->cObjGetSingle('CONTENT', $ts);
        }
        return $out;
    }
}
