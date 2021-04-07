<?php

/*
 * This file is part of Oveleon ContaoMemberNotification.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoMemberNotification;

use Contao\BackendTemplate;
use Contao\FrontendUser;
use Contao\Module;
use Contao\System;
use Patchwork\Utf8;

/**
 * Class ModuleMemberNotification
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ModuleMemberNotification extends Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_memberNotification';

	/**
	 * Return a wildcard in the back end
	 *
	 * @return string
	 */
	public function generate()
	{
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['memberNotification'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        System::loadLanguageFile('tl_member_notification');

		return parent::generate();
	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{
        $this->Template->hasNotifications = false;

        if (!System::getContainer()->get('contao.security.token_checker')->hasFrontendUser())
        {
            $this->Template->message = $GLOBALS['TL_LANG']['tl_member_notification']['loginRequired'];
            return;
        }

        $this->import(FrontendUser::class, 'User');

        switch($this->notificationMode)
        {
            case 'read':
                $strRead = 1;
                break;
            case 'unread':
                $strRead = 0;
                break;
            default:
                $strRead = null;
        }

        $objNotifications = MemberNotificationModel::findByMember($this->User->id, $strRead);
        $arrNotification = [];

        if(null !== $objNotifications)
        {
            while($objNotifications->next())
            {
                $objNotification = new \stdClass();

                $objNotification->id = $objNotifications->id;
                $objNotification->title = $objNotifications->title;
                $objNotification->teaser = $objNotifications->teaser;
                $objNotification->jumpTo = $objNotifications->jumpTo;
                $objNotification->read = $objNotifications->invisible;

                $arrNotification[] = $objNotification;
            }
        }
        else
        {
            $this->Template->message = $GLOBALS['TL_LANG']['tl_member_notification']['emptyMessage'];
        }


        $this->Template->labelMarkAsRead = $GLOBALS['TL_LANG']['tl_member_notification']['markAsRead'];
        $this->Template->amount = count($arrNotification);
        $this->Template->hasNotifications = !!$this->Template->amount;
        $this->Template->notifications = $arrNotification;
	}
}
