<?php

/*
 * This file is part of Oveleon ContaoMemberNotification.
 *
 * (c) https://www.oveleon.de/
 */

// Add ctable
array_insert($GLOBALS['TL_DCA']['tl_member']['config']['ctable'], 0, array
(
    'tl_member_notification'
));

// Add operation
$GLOBALS['TL_DCA']['tl_member']['list']['operations']['notification'] = array
(
    'href'                => 'table=tl_member_notification',
    'icon'                => 'bundles/contaomembernotification/bell.svg'
);
