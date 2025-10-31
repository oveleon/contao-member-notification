<?php

declare(strict_types=1);

namespace Oveleon\ContaoMemberNotification;

use Contao\Backend;

/**
 * Class Notification.
 */
class MemberNotification extends Backend
{
    public function loadTranslation(): void
    {
        static::loadLanguageFile('tl_member_notification');
    }
}
