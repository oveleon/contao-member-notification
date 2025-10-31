<?php

declare(strict_types=1);

use Contao\Backend;
use Contao\BackendUser;
use Contao\Config;
use Contao\CoreBundle\Exception\AccessDeniedException;
use Contao\DataContainer;
use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_member_notification'] = [
    // Config
    'config' => [
        'dataContainer' => DC_Table::class,
        'ptable' => 'tl_member',
        'switchToEdit' => true,
        'onload_callback' => [['tl_member_notification', 'checkPermission']],
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],
    // List
    'list' => [
        'sorting' => [
            'mode' => DataContainer::MODE_PARENT,
            'fields' => ['title'],
            'panelLayout' => 'filter;search,limit',
            'headerFields' => ['firstname', 'lastname'],
            'child_record_callback' => ['tl_member_notification', 'listNotification'],
        ],
        'global_operations' => [
            'all' => [
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations' => [
            'edit',
            'delete',
            'show',
        ],
    ],
    // Palettes
    'palettes' => [
        'default' => '{title_legend},title,teaser;jumpTo;invisible',
    ],
    // Fields
    'fields' => [
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'pid' => [
            'foreignKey' => 'tl_member.id',
            'sql' => 'int(10) unsigned NOT NULL default 0',
            'relation' => [
                'type' => 'belongsTo',
                'load' => 'lazy',
            ],
        ],
        'tstamp' => [
            'sql' => 'int(10) unsigned NOT NULL default 0',
        ],
        'readTstamp' => [
            'sql' => 'int(10) unsigned NOT NULL default 0',
        ],
        'title' => [
            'inputType' => 'text',
            'exclude' => true,
            'search' => true,
            'flag' => DataContainer::SORT_INITIAL_LETTER_ASC,
            'eval' => [
                'mandatory' => true,
                'maxlength' => 64,
                'tl_class' => 'w50',
            ],
            'sql' => 'varchar(64) NULL',
        ],
        'teaser' => [
            'exclude' => true,
            'inputType' => 'textarea',
            'search' => true,
            'eval' => [
                'rte' => 'tinyMCE',
                'tl_class' => 'clr',
            ],
            'sql' => 'text NULL',
        ],
        'jumpTo' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'rgxp' => 'url',
                'decodeEntities' => true,
                'maxlength' => 255,
                'dcaPicker' => true,
                'addWizardClass' => false,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'invisible' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50',
                'doNotCopy' => true,
            ],
            'sql' => [
                'type' => 'boolean',
                'default' => false,
            ],
        ],
    ],
];

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_member_notification extends Backend
{
    /**
     * Import the back end user object.
     */
    public function __construct()
    {
        parent::__construct();
        $this->import(BackendUser::class, 'User');
    }

    /**
     * Check permissions to edit the table.
     *
     * @throws AccessDeniedException
     */
    public function checkPermission(): void
    {
        if ($this->User->isAdmin) {
            return;
        }

        if (!$this->User->hasAccess('notification', 'member')) {
            throw new AccessDeniedException('Not enough permissions to access the member notification module.');
        }
    }

    /**
     * List a notification.
     */
    public function listNotification(array $row): string
    {
        $strStatus = '<span style="display:inline-block;border-radius:10px;width:10px;height:10px;margin-right:10px;background-color:%s;"></span>';

        $color = 'orange';
        $time = null;

        if ($row['invisible']) {
            $color = 'green';
            $time = $row['readTstamp'];
        }

        return '<div class="tl_content_left">' . sprintf($strStatus, $color) . $row['title'] . ($time ? '<span style="color:#999;padding-left:8px">' . date(Config::get('datimFormat') ?: 'Y-m-d', $time) . '</span>' : '') . "</div>\n";
    }
}
