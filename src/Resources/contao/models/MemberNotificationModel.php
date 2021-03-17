<?php
/*
 * This file is part of Oveleon ContaoMemberNotification.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoMemberNotification;

use Contao\Model;
use Contao\Model\Collection;

/**
 * Reads and writes notifications
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tstamp
 * @property string  $title
 * @property string  $teaser
 * @property string  $jumpTo
 * @property boolean $read
 *
 * @method static MemberNotificationModel|null findById($id, array $opt=array())
 * @method static MemberNotificationModel|null findByPk($id, array $opt=array())
 * @method static MemberNotificationModel|null findOneBy($col, $val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByTstamp($val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByTitle($val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByTeaser($val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByJumpTo($val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByRead($val, array $opt=array())
 *
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByTitle($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByTeaser($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByJumpTo($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByRead($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTitle($val, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByTeaser($val, array $opt=array())
 * @method static integer countByJumpTo($val, array $opt=array())
 * @method static integer countByRead($val, array $opt=array())
 */
class MemberNotificationModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_member_notification';
}
