<?php

namespace App\Otter;

use Poowf\Otter\Http\Resources\OtterResource;

class User extends OtterResource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\User';

    /**
     * The column of the model to display in select options
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * Get the fields and types used by the resource
     *
     * @return array
     */
    public static function fields()
    {
        return [
            'name' => 'text',
            'lastname' => 'text',
            'password' => 'password',
            'email' => 'email',
            'github_username' => 'text',
        ];
    }

    /**
     * Fields to be hidden in the resource collection
     *
     * @return array
     */
    public static function hidden()
    {
        return [
            'password'
        ];
    }

    /**
    * Get the validation rules used by the resource
    *
    * @return array
    */
    public static function validations()
    {
        return [
            'client' => [
                'create' => [
                    'name' => 'required|min:4',
                    'email' => 'required|email',
                    'password' => 'required',
                ],
                'update' => [
                    'name' => 'required|min:4',
                    'email' => 'required|email',
                    'password' => '',
                ]
            ],
            'server' => [
                'create' => [
                    'name' => 'required|min:4',
                    'email' => 'required|email|unique:users',
                    'password' => 'required',
                ],
                'update' => [
                    'name' => 'required|string|min:4',
                    'lastname' => 'required|string|min:4',
                    'email' => 'required|email|unique:users,email,' . auth()->user()->id,
                    'password' => 'required',
                ]
            ],
        ];
    }

    /**
     * Get the relations used by the resource
     *
     * @return array
     */
    public static function relations()
    {
        return [
//            'gender' => ['Gender', 'gender'],
//            'gender' => 'Gender',
        ];
    }
}