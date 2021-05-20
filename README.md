# Contao Member Notification
This extension allows to add notifications for members to inform them about certain activities.

## Add notifications
You can add notifications directly from the backend via a new bell icon (🔔) in the members area.

To be able to react to certain activities, notifications can also be created via PHP:
```php
use Oveleon\ContaoMemberNotification\MemberNotificationModel;

MemberNotificationModel::add(int $memberId, string $title, string $teaser, string $jumpTo);
```

## List notifications
For the output of the notifications a module is provided, which can output the notifications in three different modes:

`read`: Only read notifications are displayed\
`unread`: Only notifications that have not yet been read are displayed\
`all`: All notifications are displayed

> In the "unread" mode, an additional button is displayed to mark the message "as read".

## Hooks
```php
// Hook: beforeParseMemberNotification (Can be used to manipulate the data query)
public function onBeforeParseMemberNotification(int $read, ModuleMemberNotification $module): ?MemberNotificationModel
{
    // Custom logic
}
```

```php
// Hook: parseMemberNotification (Can be used to change the template output)
public function onParseMemberNotification(MemberNotificationModel $objNotifications, ModuleMemberNotification $module): void
{
    // Custom logic
}
```