<?php namespace CIC\T3site\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/**
 * Class GridElementsController
 * @package CIC\T3site\Controller
 */
class GridelementsController extends ActionController {

	/**
	 * @var array
	 */
	var $cObjData;

	/**
	 * Initialize
	 */
	public function initializeAction() {
		$this->cObjData = $this->configurationManager->getContentObject()->data;
	}

	/**
	 * Here, have some nicely pre-rendered content columns. Gridelements has already done the heavy lifting for us.
	 * @param ViewInterface $view
	 */
	public function initializeView(ViewInterface $view) {
		$this->view->assignMultiple(array(
			'content' => $this->cObjData['tx_gridelements_view_columns'],
		));
	}

	/**
	 *
	 */
	protected function assignFlexformFields() {
		$this->view->assignMultiple($this->flexformFields());
	}

	/**
	 * Get any cObjData keys that start with "flexform_"
	 * @return array
	 */
	protected function flexformFields() {
		$keys = array_filter(array_keys($this->cObjData), function ($k) {
			return strpos($k, 'flexform_') === 0;
		});
		return array_intersect_key($this->cObjData, array_flip($keys));
	}
}
