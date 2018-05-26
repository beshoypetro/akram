<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\Role;
use App\Models\Invite;
use App\Notifications\ConfirmationCode;
use App\Notifications\MembersInvitation;
use App\Notifications\resetGeneratePassword;
//use App\Transformers\DataArraySerializer;
//use App\Transformers\UserTransformer;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends AppBaseController
{


    use AuthenticatesUsers;
    private $user;
    private $jwtauth;

    /**
     * Constructor to inialize attributes
     * @param [User user, JWTAuth jwtauth, Organization team]
     * contains middleware to make exception for (login, newUserWizard, resetPassword) methods
     */
    public function __construct(User $user, JWTAuth $jwtauth)
    {
        $this->user = $user;
        $this->jwtauth = $jwtauth;
        $this->middleware('jwt.auth', ['except' => ['login', 'resetPassword', 'userToOrganization', 'newUserWizard', 'resetPassword',
            'checkInvitationToken', 'registerInvitedUsers', 'subDomainRegister', 'subDomainLogin', 'confirmation'
        ]]);
    }
    /**
     * Register new user via wizard
     * @param Request
     * @return JsonResponse contains [string jwtToken, object user ]
     */
    public function newUserWizard(CreateUserAPIRequest $userAPIRequest)
    {
        $newUser = $this->user->create([
            'role_id' => 0,
            'first_name' => $userAPIRequest->firstName,
            'last_name' => $userAPIRequest->lastName,
            'user_name' => $userAPIRequest->userName,
            'email' => $userAPIRequest->email,
            'password' => bcrypt($userAPIRequest->password),
            'phone_number' => $userAPIRequest->phoneNumber,
            'address' => $userAPIRequest->address,
            'date_of_birth' => $userAPIRequest->dateOfBirth,
        ]);

        if (!$newUser) {
            return response()->json([trans('api.failed_to_create_new_user')], 500);
        }
        $userName = $newUser->first_name;
        $newUser->notify(new ConfirmationCode($userName));

        return response()
            ->json([
                'token' => $this->jwtauth->fromUser($newUser),
                'user' => $newUser
            ]);
    }

    /** Confirming user after sending email
     * @return sendResponse in case of success
     */
    public function confirmation(Request $request)
    {
        if ($request->has('confirmationCode')) {
            //get object of this code
            $confirmation = DB::table('confirmation_codes')->where([
                ['code', $request->confirmationCode],
                ['confirmed', false]
            ])->first();

            //if confirmation is invalid
            if (!$confirmation) {
                return $this->sendError('Invalid confirmation code or confirmed before', 400);
            } else {
                DB::table('confirmation_codes')->where('code', $request->confirmationCode)->update(['confirmed' => true]);
                return $this->sendResponse(true, 'Account confirmed');
            }
        } else {
            return $this->sendError("Confirmation code not exist", 400);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function checkInvitationToken(Request $request)
    {
        if ($request->has('token')) {
            $invitation = Invite::where('token', $request->token)->first();
            if (!$invitation) {
                return $this->sendResponse(false, 'Token is not exist');
            } else {
                if ($invitation->expiration < Carbon::now('africa/cairo')) {
                    return $this->sendResponse(false, 'Invitation expired');
                }

                if ($invitation->accepted === true) {
                    return $this->sendResponse(false, 'Invitation used before');
                }

                $response = array();
                $response['expired'] = false;
                $response['accepted'] = $invitation->accepted;//true;
                $response['email'] = $invitation->email;
                return $this->sendResponse($response, 'Token is exist');
            }
        } else {
            return $this->sendError('Invalid request', 400);
        }
    }

    /** User login
     * @param Request
     * @return sendError in case of failure
     * @return jwt token & user object as response
     */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // get user credentials: email, password
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            $token = $this->jwtauth->attempt($credentials);
            if (!$token) {
                return $this->sendError('Invalid email or password', 400);
            }
        } catch (JWTAuthException $e) {
            return $this->sendError('Failed to create token', 500);

        }
        $user = User::find(Auth::user()->id);
        //if user doesn't have a confirmation record it will give me error so i have to handle it
        $confirmationRecord = DB::table('confirmation_codes')->where('user_id', $user->id)->where('is_guest', false)->first();
        $invitation = Invite::where('email', $request->email)->first();
        if ($confirmationRecord) {
            //to ensure if user email is verified before or not
//            $verification = DB::table('confirmation_codes')
//                ->where('user_id', $user->id)
//                ->where('is_guest', false)
//                ->first();
            $verified = ($confirmationRecord->confirmed === 0) ? false : true;
            if (!$verified){
                return $this->sendError('Please confirm your account before login', 400);
            }
//            return $this->sendError(trans('error_occurred_while_registration_check_confirmation_code_or_invitation'), 400);
        } elseif ($invitation) {
            if ($invitation->accepted != 1) {
                return $this->sendError('Error occurred while registration check confirmation code or invitation', 400);
            }
        } else {
            return $this->sendError('Error occurred while registration check confirmation code or invitation', 400);
        }

        return response()->json(compact('token', 'user', 'verified'));
    }

    /** completing user info after accepting invitation mail
     * @param Request
     * @return sendError in case of update failure
     * @return success sendResponse in case of success
     */
    public function updateUserWizard(UpdateUserAPIRequest $userAPIRequest)
    {
        //get current date
        $current = Carbon::now('africa/cairo');

        //get users's invitation data
        $userInvitation = Invite::where('email', $userAPIRequest->email)->first();

        //check if userInvitation return
        if (!$userInvitation) {
            return $this->sendError("Invitation not exist", 410);
        } else {
            //get invitation token
            $token = Invite::find($userInvitation->id)->token;
            //check if token exist
            if ($token) {
                //check expiration date
                if ($userInvitation->expiration <= $current) {
                    //echo "invitation expired";
                    return $this->sendError("Invitation Expired", 410);
                } else {
                    // check if invitation is accepted
                    if ($userInvitation->accepted == 0) {
                        //update user's data
                        $updateUser = User::where('email', $userAPIRequest->email)->update([
                            'first_name' => $userAPIRequest->get('first_name'),
                            'last_name' => $userAPIRequest->get('last_name'),
                            'user_name' => $userAPIRequest->get('user_name'),
                            // 'email' => $userAPIRequest->get('email'),
                            'password' => bcrypt($userAPIRequest->get('password')),
                            'is_admin' => 0,
                            'is_owner' => 0
                        ]);

                        //update user's invitation data
                        $updateInvitation = Invite::where('email', $userAPIRequest->email)->update([
                            'accepted' => 1,
                            'accepted_at' => $current,
                            'name' => $userAPIRequest->get('name')
                        ]);

                        // if update User or updateInvitation doesn't return true (not updated)
                        if (!$updateUser || !$updateInvitation) {
                            return $this->sendError("Error occurred during update", 404);
                        } else {
                            return $this->sendResponse(true, "Account updated successfully");
                        }
                    } else {
                        return $this->sendError("This link is activated before", 404);
                    }
                }
            } else {
                return $this->sendError("This invitation not exist", 404);
            }
        }

    }

    /** Send invitation via email to multi users
     * @param Request
     * @return sendError in case of failure
     * @return success sendResponse in case of success
     */
    public function invitationWizard(Request $request)
    {
        //check if request not empty
        if ($request->has("emails")) {
            foreach ($request->emails as $email) {
                $invitation = Invite::where('email', $email)->first();
                //check if Invitation input is saved before
                if ($invitation) {
//                    //check if invitation is accepted before
                    if ($invitation->accepted) {
                        return $this->sendError("Invitation accepted before", 400);
                    } else {
                        //invitation not accepted before but it exists
                        if ($invitation->expiration < Carbon::now('africa/cairo')) {
                            $invitation->update([
                                "expiration" => Carbon::now('africa/cairo')->addDays(3),
                            ]);
                        } else {
                            return $this->sendResponse(true, "Invitation sent before and not expired");
                        }
                        $invitation->notify(new MembersInvitation());
                        return $this->sendResponse(true, "Invitation updated successfully");
                    }
                } else {//new invitation
                    $user = User::where('email', $email)->first();

                    if ($user) {
                        return $this->sendError('User is already exist in organization', 400);
                    }

                    $newInvitation = Invite::create([
                        "name" => $email,
                        "token" => Uuid::uuid4(),
                        "accepted" => false,
                        "email" => $email,
                        "organization_id" => Auth::user()->organization_id,
                        "expiration" => Carbon::now('africa/cairo')->addDays(3)
                    ]);

                    $inviter = Auth::user();
                    $newInvitation->notify(new MembersInvitation($inviter));
                }
            }
            return $this->sendResponse(true, "Invitation sent successfully");
        } else {
            return $this->sendError("Email required", 400);
        }
    }

    /** Create organization by the owner
     * @param Request
     * @return sendError in case of failure
     * @return success sendResponse in case of success
     */


    public function logout()
    {
        $this->jwtauth->invalidate($this->jwtauth->getToken());
        return $this->sendResponse(true, "Come back soon :)");
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function resetPassword(Request $request)
    {
        if ($request->has('email')) {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return $this->sendError('Email not exist', 400);
            }
            $generatedPassword = str_random(6);
            $user->update([
                'password' => $generatedPassword,
            ]);
            $userName = $user->first_name;
            $user->notify(new resetGeneratePassword($userName));
        } else {
            return $this->sendError('Invalid request', 400);
        }
        return $this->sendResponse(true, 'Password sent successfully to your mail');
    }

    /**
     * @param Request $request
     * @return mixed
     */
//    public function getUserByToken(Request $request)
//    {
//        if ($request->has('jwtToken')) {
//            $token = $request->jwtToken;
//            if ($token == $this->jwtauth->getToken()) {
//                $user = $this->jwtauth->authenticate();
//                $profile = fractal()->serializeWith(new DataArraySerializer())
//                    ->item($user, new UserTransformer(), false)->toArray();
//                return $this->sendResponse(true, $profile, "User retrieved successfully");
//            } else {
//                return $this->sendError("Invalid token", 400);
//            }
//        } else {
//            return $this->sendError("Invalid request", 400);
//        }
//    }

    /**
     * @return mixed
     */
    public function getAllRoles()
    {
        $roles = Role::all();
        if (!$roles) {
            return $this->sendError('Not found roles', 400);
        } else {
            return $this->sendResponse($roles, 'Roles retrieved successfully');
        }
    }

    /**
     * @param CreateUserAPIRequest $userAPIRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerInvitedUsers(CreateUserAPIRequest $userAPIRequest)
    {
        $invitation = Invite::where('email', $userAPIRequest->email)->first();
        if (!$invitation) {
            return $this->sendError('Invitation not exist', 400);
        }

        if ($invitation->expiration < Carbon::now('africa/cairo')) {
            return $this->sendError('Invitation expired', 400);
        }

        $newUser = $this->user->create([
            'organization_id' => $invitation->organization_id,
            'role_id' => 5,
            'first_name' => $userAPIRequest->firstName,
            'last_name' => $userAPIRequest->lastName,
            'user_name' => $userAPIRequest->userName,
            'email' => $userAPIRequest->email,
            'password' => bcrypt($userAPIRequest->password),
            'is_admin' => 0,
            'is_owner' => 0,
            'phone_number' => $userAPIRequest->phoneNumber,
            'address' => $userAPIRequest->address,
            'date_of_birth' => $userAPIRequest->dateOfBirth,
        ]);

        $newUser->attachRole(5);
        if (!$newUser) {
            return $this->sendError('Failed to create new user', 500);
        }

        $invitation->update([
            'accepted' => 1
        ]);

        return response()
            ->json([
                'token' => $this->jwtauth->fromUser($newUser),
                'user' => $newUser
            ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getUserByJwt(Request $request)
    {
        if ($request->has('jwtToken')) {
            try {
                return $this->jwtauth->toUser($request->jwtToken);
            } catch (TokenInvalidException $exception) {
                return $this->sendError('Invalid token', 404);
            }
        } else {
            return $this->sendError('Invalid request', 404);
        }
    }

}


