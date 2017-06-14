<?php

namespace CIC\T3site\Hook;

use TYPO3\CMS\Core\SingletonInterface;

/**
 * For adding custom view assignments to pages when rendered by Fluidpage
 * Class PageTemplateViewAssignment
 * @package CIC\T3site\Hook
 */
class PageTemplateViewAssignment implements SingletonInterface
{
    /**
     * @var \TYPO3\CMS\Core\Resource\FileRepository
     * @inject
     */
    var $fileRepository;

    /**
     * @var \TYPO3\CMS\Frontend\Page\PageRepository
     * @inject
     */
    protected $pageRepository;

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     * @inject
     */
    var $cObj;

    /**
     * @return array
     */
    public function getAssignments()
    {
        $staffUid = $GLOBALS['TSFE']->page['tx_t3site_staff_relation'];
        $out = array(
            'articleDate' => $GLOBALS['TSFE']->page['tx_t3site_article_date']
        );

        if ($page = $this->pageRepository->getPage(intval($staffUid))) {
            $out['staffAuthor'] = $page;
            $out['staffImage'] = $this->fileRepository->findByRelation('pages', 'media', $staffUid);
        }

        return $out;
    }
}
