<?php

namespace App\Http\Helpers;

use Spatie\Permission\Models\Role;

class Helpers
{


    /**
     * Fuction Get roles for select
     *
     * @return array
     */
    public static function getRolesName(): object
    {
        $role_permissions = Role::all();

        $roles = [];
        foreach ($role_permissions as $key => $item) {
            array_push(
                $roles,
                [
                    'id' => $item->id,
                    'name' => __(config('constants.ROLES.' . str_replace(' ', '_', strtoupper($item->name)) . '.NAME_' . mb_strtoupper(app()->getLocale()))),
                    'description' => __(config('constants.ROLES.' . strtoupper($item->name) . '.DESCRIPTION_' . mb_strtoupper(app()->getLocale())))
                ]
            );
        }

        return collect($roles);
    }

     /**
     * Fuction Get valiation statuses for select
     *
     * @return array
     */
    public static function getValidation(): object
    {
        $validation_names = config('constants.DOCUMENT_VALIDATION_NAME_'.app()->getLocale());

        $roles = [];
        foreach ($validation_names as $key => $item) {
            // dd($key);
            array_push(
                $roles,
                [
                    'id' => $key,
                    'name' => $item,
                ]
            );
        }

        return collect($roles);
    }
}
