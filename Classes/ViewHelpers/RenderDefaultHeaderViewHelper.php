<?php

namespace CIC\T3site\ViewHelpers;
use TYPO3\CMS\Core\Error\Exception;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Renders the header for a content element in cases where TYPO3 isn't managing header information automatically, i.e.
 * when you're rendering cObj data manually in your view:
 *
 * In the view:
 * <t:renderDefaultHeader />
 *
 * Class RenderDefaultHeaderViewHelper
 * @package CIC\T3site\ViewHelpers
 */
class RenderDefaultHeaderViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager;

    /**
     * @return string
     * @throws Exception
     */
    public function render() {
        $data = $this->configurationManager->getContentObject()->data;
        if (!MathUtility::canBeInterpretedAsInteger($data['header_layout'])) {
            return '';
        }

        if ($data['header_layout'] > 5 || $data['header_layout'] < 1) {
            throw new Exception('Please specify a header layout between 1 and 5');
        }

        $tagName = "h" . intval($data['header_layout']);

        return "<$tagName>{$data['header']}</$tagName>";
    }

}
