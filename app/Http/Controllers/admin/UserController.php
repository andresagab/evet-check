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
     * Store a new user in db and return it
     * @param array $data => collection with fields name, code, state, final_password and role_name
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public static function store(array $data) : \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
    {

        # store data
        User::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'state' => $data['state'],
            'password' => $data['final_password'],
        ]);

        # search user by code
        $user = User::query()->where('code', $data['code'])->first();

        # if user was fund, sync role
        $user?->syncRoles([$data['role_name']]);

        return $user ?? null;

    }

    /**
     * Update a old user
     * @param $user_id => the user id
     * @param array $data => the data to update
     * @return array => response with message and state keys
     */
    public static function update($user_id, array $data) : array
    {

        # define default message as updated
        $message = __('messages.responses.updated');
        $updated = true;

        # search resource
        $user = User::query()->find($user_id);

        # set fields
        $user->name = $data['name'];
        $user->code = $data['code'];
        $user->state = $data['state'];

        # if 'password' is dirty, set password
        if ($data['password'] !== '')
            $user->password = $data['final_password'];

        # update data, if not then set wrong message
        if (!$user->update())
        {
            $message = __('messages.errors.not_updated');
            $updated = false;
        }
        # else, sync roles
        else
            $user->syncRoles([$data['role_name']]);

        return [
            'message' => $message,
            'state' => $updated,
        ];

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
