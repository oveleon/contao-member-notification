<?php

declare(strict_types=1);

use Oveleon\ContaoMemberNotification\MemberNotification;

$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = [MemberNotification::class, 'loadTranslation'];

$GLOBALS['TL_DCA']['tl_module']['palettes']['memberNotification'] = '{title_legend},name,headline,type;{config_legend},notificationMode,notificationSorting,numberOfItems,perPage,notificationCount,notificationDateTime;{template_legend:collapsed},customTpl;{protected_legend:collapsed},protected;{expert_legend:collapsed},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['fields']['notificationMode'] = [
    'exclude' => true,
    'inputType' => 'select',
    'options' => ['all', 'read', 'unread'],
    'eval' => [
        'tl_class' => 'w50',
    ],
    'reference' => &$GLOBALS['TL_LANG']['tl_member_notification'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['notificationSorting'] = [
    'exclude' => true,
    'inputType' => 'select',
    'options' => ['ASC', 'DESC'],
    'eval' => [
        'tl_class' => 'w50',
    ],
    'reference' => &$GLOBALS['TL_LANG']['tl_member_notification'],
    'sql' => "varchar(8) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['notificationCount'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12 clr',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['notificationDateTime'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];
