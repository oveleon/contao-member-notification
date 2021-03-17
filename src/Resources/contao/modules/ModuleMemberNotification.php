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

		return parent::generate();
	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{
	    $this->Template->login = true;

        if (!System::getContainer()->get('contao.security.token_checker')->hasFrontendUser())
        {
            $this->Template->login = false;
            $this->Template->message = 'Bitte loggen Sie sich ein um Ihre Benachrichtigungen zu sehen';
            return;
        }

        $this->import(FrontendUser::class, 'User');

        switch($this->notificationMode)
        {
            case 'read':
                $objNotifications = MemberNotificationModel::findBy(['read=1', 'pid='.$this->User->id], null);
                break;
            case 'notread':
                $objNotifications = MemberNotificationModel::findBy(['read=0', 'pid='.$this->User->id], null);
                break;
            default:
                $objNotifications = MemberNotificationModel::findBy(['pid='.$this->User->id], null);
        }

        $arrNotification = [];

        if(null !== $objNotifications)
        {
            while($objNotifications->next())
            {
                $objNotification = new \stdClass();

                $objNotification->title = $objNotifications->title;
                $objNotification->teaser = $objNotifications->teaser;
                $objNotification->jumpTo = $objNotifications->jumpTo;
                $objNotification->read = $objNotifications->read;

                $arrNotification[] = $objNotification;
            }
        }
        else
        {
            $this->Template->message = 'Es gibt keine neue Benachrichtigungen';
        }

        $this->Template->hasNotifications = !!count($arrNotification);
        $this->Template->notifications = $arrNotification;
	}
}
