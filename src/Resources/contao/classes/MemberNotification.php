<?php
/*
 * This file is part of Oveleon ContaoMemberNotification.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoMemberNotification;

use Contao\Backend;

/**
 * Class Notification
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class MemberNotification extends Backend
{
    public function loadTranslation(){
        static::loadLanguageFile('tl_member_notification');
    }
}
