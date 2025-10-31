<?php

declare(strict_types=1);

use Contao\ArrayUtil;

// Add ctable
ArrayUtil::arrayInsert($GLOBALS['TL_DCA']['tl_member']['config']['ctable'], 0, ['tl_member_notification']);

// Add operation
$GLOBALS['TL_DCA']['tl_member']['list']['operations']['notification'] = [
    'href' => 'table=tl_member_notification',
    'icon' => 'bundles/contaomembernotification/bell.svg',
];
