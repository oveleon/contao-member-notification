<?php

declare(strict_types=1);

namespace Oveleon\ContaoMemberNotification\Controller;

use Contao\CoreBundle\Framework\ContaoFramework;
use Oveleon\ContaoMemberNotification\MemberNotificationModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ContentApiController provides all routes.
 */
#[Route(defaults: [
    '_scope' => 'frontend',
])]
class MemberNotificationController extends AbstractController
{
    public function __construct(
        private readonly ContaoFramework $framework,
    ) {
    }

    /**
     * Set a notification to read.
     */
    #[Route(path: '/membernotification/read/{id}', name: 'mnc_read')]
    public function readAction(Request $request, string $id): Response
    {
        $this->framework->initialize();

        $objNotification = MemberNotificationModel::findById($id);

        $objNotification->invisible = 1;
        $objNotification->readTstamp = time();

        $objNotification->save();

        return new Response('Notification with ID ' . $id . ' successfully marked as read.');
    }
}
