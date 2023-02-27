<?php

/*
 * This file is part of Oveleon ContaoMemberNotification.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoMemberNotification;

use Contao\BackendTemplate;
use Contao\Config;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\Environment;
use Contao\FrontendUser;
use Contao\Input;
use Contao\Module;
use Contao\Pagination;
use Contao\System;

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
            $objTemplate->wildcard = '### ' . mb_strtoupper($GLOBALS['TL_LANG']['FMD']['memberNotification'][0], 'UTF-8') . ' ###';
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
        $this->Template->message          = $GLOBALS['TL_LANG']['tl_member_notification']['emptyMessage'];
        $this->Template->labelMarkAsRead  = $GLOBALS['TL_LANG']['tl_member_notification']['markAsRead'];

        if (!System::getContainer()->get('contao.security.token_checker')->hasFrontendUser())
        {
            $this->Template->message = $GLOBALS['TL_LANG']['tl_member_notification']['loginRequired'];
            return;
        }

        $this->import(FrontendUser::class, 'User');

        $limit  = null;
        $offset = 0;

        if ($this->numberOfItems > 0)
        {
            $limit = $this->numberOfItems;
        }

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

        $objNotifications = null;

        $this->Template->hasNotifications = false;

        $intTotal = MemberNotificationModel::countByMember($this->User->id, $strRead);

        if ($intTotal < 1)
        {
            return;
        }

        if ($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage))
        {
            // Adjust the overall limit
            if (isset($limit))
            {
                $intTotal = min($limit, $intTotal);
            }

            $id   = 'page_n' . $this->id;
            $page = Input::get($id) ?? 1;

            if ($page < 1 || $page > max(ceil($intTotal/$this->perPage), 1))
            {
                throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
            }

            $limit   = $this->perPage;
            $offset += (max($page, 1) - 1) * $this->perPage;

            if ($offset + $limit > $intTotal)
            {
                $limit = $intTotal - $offset;
            }

            // Add the pagination menu
            $objPagination = new Pagination($intTotal, $this->perPage, Config::get('maxPaginationLinks'), $id);
            $this->Template->pagination = $objPagination->generate("\n  ");
        }

        // HOOK: add custom parse logic
        if (isset($GLOBALS['TL_HOOKS']['beforeParseMemberNotification']) && \is_array($GLOBALS['TL_HOOKS']['beforeParseMemberNotification']))
        {
            foreach ($GLOBALS['TL_HOOKS']['beforeParseMemberNotification'] as $callback)
            {
                $this->import($callback[0]);
                $objNotifications = $this->{$callback[0]}->{$callback[1]}($strRead, $this);
            }
        }

        if (null === $objNotifications)
        {
            $arrOptions = [
                'order' => 'tstamp ' . $this->notificationSorting
            ];

            if (null !== $limit)
            {
                $arrOptions['limit'] = $limit;
            }

            if ($offset > 0)
            {
                $arrOptions['offset'] = $offset;
            }

            $objNotifications = MemberNotificationModel::findByMember($this->User->id, $strRead, $arrOptions);
        }

        $arrNotification = [];

        if (null !== $objNotifications)
        {
            while ($objNotifications->next())
            {
                $objNotification = new \stdClass();

                $objNotification->id       = $objNotifications->id;
                $objNotification->tstamp   = $objNotifications->tstamp;
                $objNotification->dateTime = date(Config::get('datimFormat'), (int) $objNotifications->tstamp);
                $objNotification->title    = $objNotifications->title;
                $objNotification->teaser   = $objNotifications->teaser;
                $objNotification->jumpTo   = $objNotifications->jumpTo;
                $objNotification->read     = $objNotifications->invisible;

                $arrNotification[] = $objNotification;
            }
        }

        $this->Template->amount           = count($arrNotification);
        $this->Template->hasNotifications = !!$this->Template->amount;
        $this->Template->notifications    = $arrNotification;

        // HOOK: add custom parse logic
        if (isset($GLOBALS['TL_HOOKS']['parseMemberNotification']) && \is_array($GLOBALS['TL_HOOKS']['parseMemberNotification']))
        {
            foreach ($GLOBALS['TL_HOOKS']['parseMemberNotification'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($objNotifications, $this);
            }
        }
	}
}
