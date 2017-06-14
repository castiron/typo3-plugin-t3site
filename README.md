# T3site

## Installation

### Install with composer

```bash
composer require castiron/typo3-plugin-t3site
```

### Add base configuration

You need to add the "AdditionalConfiguration" stuff from the extension by adding this line to your 
 `typo3conf/AdditionalConfiguration.php`:
 
```php
require(PATH_site . 'typo3conf/ext/t3site/Configuration/Local/AdditionalConfiguration.php');
```

### Add tsconfig

In your top level page properties, in the `Page TSConfig` field:

```typo3_typoscript
<INCLUDE_TYPOSCRIPT: source="FILE:typo3conf/ext/t3site/Configuration/TSConfig/site.txt">
```

## Usage / utility notes

### Adding News template layouts

The `news` extension comes with some rather crufty config/setup structure. Here's a way you can add new layout
 options in the news plugin:

```php
\CIC\T3site\Utility\NewsUtility::addTemplateLayout($label, $key);
```

Make a config file in your theme in this location:
```php
# typo3conf/ext/my-theme/Configuration/CustomContent/General.php
<?php

return [
    'my_content_element_type' => [
        'action' => 'mirror',
        'noCache' => false,
        'flexform' => "FILE:EXT:{$_EXTKEY}/Resources/Configuration/FlexForms/my_content_flexform.xml",
        'ui' => '
			CType;;4;button;1-1-1,
			header,
			pi_flexform,
			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
			--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
			--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access,
			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended,
			tx_gridelements_container,
			tx_gridelements_columns',
        'label' => 'Render a list of flabble flobble wodgets'
    ],
];
```

... then, in both ext_localconf.php:

```php
/**
 * This registers custom content elements as per the above config. Sister call to register
 * the elements for the backend is in ext_tables.php
 */
$customContentElements = \CIC\T3site\Utility\CustomContentElementUtility::getCceConfiguration($_EXTKEY, 'General');
\CIC\T3site\Utility\CustomContentElementUtility::addCustomContentElements($_EXTKEY, $customContentElements, 'CIC');
```

### Support for adding custom page types

In your theme's `ext_tables.php`:

```php
\CIC\T3site\Utility\CustomPageTypeUtility::addPageType([
    'name' => 'My Type',
    'dokType' => \Me\MyTheme\Service\DokType::MY_TYPE,
    'showItemConfig' => '
		--div--;My Custom Stuff, --palette--;Details;standard,title;Name,tx_t3site_bmp_grantee, --linebreak--, tx_my_description,tx_my_logo,media;Hero Image,tx_my_geographic_reach_regions,tx_my_news_category_id,tx_my_legacy_id,
		--div--;My Other Thing, tx_my_other_stuff,
		--div--;My Categories, categories,
		--div--;LLL:EXT:cms/locallang_tca.xlf:pages.tabs.access, --palette--;LLL:EXT:cms/locallang_tca.xlf:pages.palettes.visibility;visibility, --palette--;LLL:EXT:cms/locallang_tca.xlf:pages.palettes.access;access,
		--div--;LLL:EXT:cms/locallang_tca.xlf:pages.tabs.metadata, --palette--;LLL:EXT:cms/locallang_tca.xlf:pages.palettes.abstract;abstract, tx_seo_titletag;;;;, --linebreak--,nav_title;Alternative Navigation Name, --linebreak--, tx_realurl_pathsegment;;137;;, tx_realurl_exclude, --palette--;LLL:EXT:cms/locallang_tca.xlf:pages.palettes.metatags;metatags, --palette--;LLL:EXT:cms/locallang_tca.xlf:pages.palettes.editorial;editorial'
]);
```

Note the (optional) use of a `\Me\MyTheme\Service\DokType` class for making things a bit easier to read.
