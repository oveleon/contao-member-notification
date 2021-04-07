<?php

/*
 * This file is part of Oveleon ContaoMemberNotification.
 *
 * (c) https://www.oveleon.de/
 */

$GLOBALS['TL_DCA']['tl_member_notification'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_member',
        'switchToEdit'                => true,
        'onload_callback' => array
        (
            array('tl_member_notification', 'checkPermission')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 4,
            'fields'                  => array('title'),
            'panelLayout'             => 'filter;search,limit',
            'headerFields'            => array('firstname', 'lastname'),
            'child_record_callback'   => array('tl_member_notification', 'listNotification')
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'href'                => 'table=tl_member_notification&amp;act=edit',
                'icon'                => 'edit.svg'
            ),
            'delete' => array
            (
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'                     => '{title_legend},title,teaser;jumpTo;invisible'
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'foreignKey'              => 'tl_member.id',
            'sql'                     => "int(10) unsigned NOT NULL default 0",
            'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default 0"
        ),
        'readTstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default 0"
        ),
        'title' => array
        (
            'inputType'               => 'text',
            'exclude'                 => true,
            'search'                  => true,
            'flag'                    => 1,
            'eval'                    => array('mandatory'=>true, 'maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NULL"
        ),
        'teaser' => array
        (
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'search'                  => true,
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'jumpTo' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>true, 'addWizardClass'=>false, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'invisible' => array
        (
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50', 'doNotCopy'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        )
    )
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class tl_member_notification extends Contao\Backend
{
    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('Contao\BackendUser', 'User');
    }

    /**
     * Check permissions to edit the table
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function checkPermission()
    {
        if ($this->User->isAdmin)
        {
            return;
        }

        if (!$this->User->hasAccess('notification', 'member'))
        {
            throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to access the member notification module.');
        }
    }

    /**
     * List a notification
     *
     * @param array $row
     *
     * @return string
     */
    public function listNotification($row)
    {
        $strStatus = '<span style="display:inline-block;border-radius:10px;width:10px;height:10px;margin-right:10px;background-color:%s;"></span>';

        $color     = 'orange';
        $time      = null;

        if ($row['invisible'])
        {
            $color = 'green';
            $time  = $row['readTstamp'];
        }

        return '<div class="tl_content_left">' . sprintf($strStatus, $color) . $row['title'] . ($time ? '<span style="color:#999;padding-left:8px">' . date(\Contao\Config::get('datimFormat') ?: 'Y-m-d', $time) . '</span>' : '') . "</div>\n";
    }

}
