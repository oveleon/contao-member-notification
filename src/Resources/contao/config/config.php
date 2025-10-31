<?php

declare(strict_types=1);

use Oveleon\ContaoMemberNotification\MemberNotificationModel;
use Oveleon\ContaoMemberNotification\ModuleMemberNotification;

// Back end modules
$GLOBALS['BE_MOD']['accounts']['member']['tables'][] = 'tl_member_notification';

// Front end modules
$GLOBALS['FE_MOD']['user']['memberNotification'] = ModuleMemberNotification::class;

// Models
$GLOBALS['TL_MODELS']['tl_member_notification'] = MemberNotificationModel::class;
