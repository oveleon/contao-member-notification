<?php

namespace Oveleon\ContaoMemberNotification\Controller;

use Oveleon\ContaoMemberNotification\MemberNotificationModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Contao\CoreBundle\Framework\ContaoFramework;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ContentApiController provides all routes.
 *
 * @Route(defaults={"_scope" = "frontend"})
 */
class MemberNotificationController extends AbstractController
{
    /**
     * @var ContaoFramework
     */
    private $framework;

    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    /**
     * Set a notification to read
     *
     * @Route("/membernotification/read/{id}", name="mnc_read")
     *
     * @param Request $request
     * @param $id
     *
     * @return Response
     */
    public function readAction(Request $request, $id)
    {
        $this->framework->initialize();

        $objNotification = MemberNotificationModel::findById($id);

        $objNotification->invisible = 1;
        $objNotification->readTstamp = time();

        $objNotification->save();

        return new Response('Notification with ID ' . $id . ' successfully marked as read.');
    }
}
