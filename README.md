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

## Styling and customization
**Dynamic list:**\
A dynamic list defines a list in which notifications are removed from the list when clicked (mostly mode unread). This case usually occurs when the member can mark notifications as read via a bell or similar.

Within the template `mod_memberNotification.html5` can be influenced whether notification item will be removed after click. To not apply this behavior the HTML attribute `data-mnc-delete-on-mark` must be removed.

By removing this HTML attribute, the item is no longer removed but the class `read` is added after click.

**Display the "No new messages" item:**\
The item is always displayed since version `1.0.4`. In conjunction with a dynamic list, the item can be styled as follows to display it only when there are no new messages:

```css
.notifications .message{
    display: none;
}

.notifications .message:only-child{
    display: block;
}
```

If the HTML attribute `data-mnc-delete-on-mark` should be removed, the following query in the template can be used to influence the output of the message:
```php
<?php if($this->hasNotifications): ?>
    <div class="message">
        <?=$this->message?>
    </div>
<?php endif; ?>
```

**Advanced use:**\
Further peculiarities can be caught by the event `mnc-count`. This event is always fired as soon as a notification is marked as read.

```js
window.addEventListener('mnc-count', function (e) {
  console.log(e.detail);
  
  // Output:
  // {
  //   element: DOMElement,
  //   counter: DOMElement,
  //   currentCount: Number
  // }
    
}, false);
```

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
