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
 * @property integer $readTstamp
 * @property string  $title
 * @property string  $teaser
 * @property string  $jumpTo
 * @property boolean $invisible
 *
 * @method static MemberNotificationModel|null findById($id, array $opt=array())
 * @method static MemberNotificationModel|null findByPk($id, array $opt=array())
 * @method static MemberNotificationModel|null findOneBy($col, $val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByTstamp($val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByReadTstamp($val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByTitle($val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByTeaser($val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByJumpTo($val, array $opt=array())
 * @method static MemberNotificationModel|null findOneByInvisible($val, array $opt=array())
 *
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByTstamp($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByReadTstamp($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByTitle($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByTeaser($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByJumpTo($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findByInvisible($val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findMultipleByIds($var, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findBy($col, $val, array $opt=array())
 * @method static Collection|MemberNotificationModel[]|MemberNotificationModel|null findAll(array $opt=array())
 *
 * @method static integer countById($id, array $opt=array())
 * @method static integer countByTitle($val, array $opt=array())
 * @method static integer countByTstamp($val, array $opt=array())
 * @method static integer countByReadTstamp($val, array $opt=array())
 * @method static integer countByTeaser($val, array $opt=array())
 * @method static integer countByJumpTo($val, array $opt=array())
 * @method static integer countByInvisible($val, array $opt=array())
 */
class MemberNotificationModel extends Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_member_notification';

    /**
     * Find notification by their member and read-status
     *
     * @param numeric $memberId
     * @param null    $read
     * @param array   $arrOptions An optional options array
     *
     * @return MemberNotificationModel|null The model or null if there is no notification
     */
    public static function findByMember($memberId, $read=null, array $arrOptions=array())
    {
        if(null === $read)
        {
            return static::findBy(['pid=?'], [$memberId], $arrOptions);
        }

        return static::findBy(['invisible=?', 'pid=?'], [$read, $memberId], $arrOptions);
    }

    /**
     * Counts notifications by member and read-status
     *
     * @param numeric $memberId
     * @param null    $read
     * @param array   $arrOptions An optional options array
     *
     * @return int|null The model or null if there is no notification
     */
    public static function countByMember($memberId, $read=null)
    {
        if (null === $read)
        {
            return static::countBy(['pid=?'], [$memberId]);
        }

        return static::countBy(['invisible=?', 'pid=?'], [$read, $memberId]);
    }

    public static function add($memberId, $title, $teaser, $jumpTo='')
    {
        $objNotification = new static();

        $objNotification->tstamp = time();
        $objNotification->pid = $memberId;
        $objNotification->title = $title;
        $objNotification->teaser = $teaser;
        $objNotification->jumpTo = $jumpTo;
        $objNotification->invisible = 0;

        $objNotification->save();
    }
}
