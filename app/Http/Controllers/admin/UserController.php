<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\CommonUtils;

class UserController extends Controller
{

    /**
     * return main view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('pages.admin.users.index');
    }

    /**
     * Delete a user resource
     * @param User $user
     * @return array
     */
    public static function delete(User $user): array
    {
        # define response
        $response = [
            'state' => false,
            'message' => __('messages.errors.not_deleted'),
            'icon' => 'warning',
        ];

        # DELETE PROFILE PHOTO
        # if user has a profile photo, then delete the file
        if ($user->profile_photo_path)
            CommonUtils::deleteFileFromAppStorage($user->profile_photo_path);

        # DELETE ROLES OF USER
        # load roles of user
        $roles = $user->roles()->pluck('id')->toArray();
        # remove roles of user
        $user->removeRoles($roles);

        # DELETE PERMISSIONS OF USER
        # load permissions of user
        $permissions = $user->permissions()->pluck('id')->toArray();
        # remove permissions of user
        $user->removePermissions($permissions);

        # DELETE USER
        # if resource is deleted
        if ($user->delete())
        {
            $response['state'] = true;
            $response['message'] = __('messages.responses.deleted');
            $response['icon'] = 'success';
        }

        return $response;

    }

}
