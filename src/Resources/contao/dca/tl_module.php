<?php

/*
 * This file is part of Oveleon ContaoMemberNotification.
 *
 * (c) https://www.oveleon.de/
 */

$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = ['Oveleon\ContaoMemberNotification\MemberNotification', 'loadTranslation'];

$GLOBALS['TL_DCA']['tl_module']['palettes']['memberNotification'] = '{title_legend},name,headline,type;{config_legend},notificationMode,notificationSorting,notificationCount,notificationDateTime;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['fields']['notificationMode'] = array
(
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => ['all', 'read', 'unread'],
    'eval'                    => array('tl_class'=>'w50'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_member_notification'],
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['notificationSorting'] = array
(
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => ['ASC', 'DESC'],
    'eval'                    => array('tl_class'=>'w50'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_member_notification'],
    'sql'                     => "varchar(8) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['notificationCount'] = array
(
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['notificationDateTime'] = array
(
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);
