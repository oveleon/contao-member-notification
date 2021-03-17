<?php

/*
 * This file is part of Oveleon ContaoMemberNotification.
 *
 * (c) https://www.oveleon.de/
 */

// Back end modules
$GLOBALS['BE_MOD']['accounts']['member']['tables'][] = 'tl_member_notification';

// Front end modules
$GLOBALS['FE_MOD']['user']['memberNotification'] = 'Oveleon\ContaoMemberNotification\ModuleMemberNotification';

// Models
$GLOBALS['TL_MODELS']['tl_member_notification'] = Oveleon\ContaoMemberNotification\MemberNotificationModel::class;
