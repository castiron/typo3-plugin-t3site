<?php

return [
    'mirror' => [
        'action' => 'mirror',
        'noCache' => false,
        'flexform' => "FILE:EXT:t3site/Configuration/FlexForms/mirror_flexform.xml",
        'ui' => '
			CType;;4;button;1-1-1,
			pi_flexform,
			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
			--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
			--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access,
			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended,
			tx_gridelements_container,
			tx_gridelements_columns',
        'label' => 'Render Content from the same column on another page'
    ],
];
