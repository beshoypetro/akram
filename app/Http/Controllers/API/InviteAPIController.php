<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\UpdateInviteAPIRequest;
use App\Models\Invite;
use App\Repositories\InviteRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Ramsey\Uuid\Uuid;
use Response;

/**
 * Class InviteController
 * @package App\Http\Controllers\API
 */
class InviteAPIController extends AppBaseController
{
    /** @var  InviteRepository */
    private $inviteRepository;

    public function __construct(InviteRepository $inviteRepo)
    {
        $this->inviteRepository = $inviteRepo;
    }

    /**
     * Display a listing of the Invite.
     * GET|HEAD /invites
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->inviteRepository->pushCriteria(new RequestCriteria($request));
        $this->inviteRepository->pushCriteria(new LimitOffsetCriteria($request));
        $invites = $this->inviteRepository->all();

        return $this->sendResponse($invites->toArray(), 'Invites retrieved successfully');
    }


    public function storeInvitation($email, Invite $invite)
    {
        // get the current time
        $current = Carbon::now('africa/cairo');

        // add 3 days to the current time
        $expires = $current->addDays(3);

        $token = $this->generateToken();

        $newInvitation = $invite->create([
            'token' => $token,
            'name' => '',
            'email' => $email,
            'expiration' => $expires,
            'accepted' => 0,
            'accepted_at' => null,
        ]);

        $invitation = Invite::where('token', '=', $token)->first();//['attributes'];

        if (!$newInvitation) {
            return $this->sendError(trans('Failed to create invitation'), 500);
        } else {
//            return $this->sendResponse(true, $token,trans('api.invitation_saved_successfully'));
            return $invitation;
        }
    }

    protected function generateToken()
    {
        $token = Uuid::uuid4(); //str_random(10);
        if (Invite::where('token', $token)->first()) {
            return $this->generateToken();
        }
        return $token;
    }


    public function update($id, UpdateInviteAPIRequest $request)
    {
        $input = $request->all();

        /** @var Invite $invite */
        $invite = $this->inviteRepository->findWithoutFail($id);

        if (empty($invite)) {
            return $this->sendError('Invite not found');
        }

        $invite = $this->inviteRepository->update($input, $id);

        return $this->sendResponse($invite->toArray(), 'Invite updated successfully');
    }


}
