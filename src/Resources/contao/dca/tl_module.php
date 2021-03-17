<?php

/*
 * This file is part of Oveleon ContaoMemberNotification.
 *
 * (c) https://www.oveleon.de/
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['memberNotification'] = '{title_legend},name,headline,type;{config_legend},notificationMode;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['fields']['notificationMode'] = array
(
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => ['all', 'read', 'notread'],
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
