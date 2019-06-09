<?php

namespace App\Otter;

use Poowf\Otter\Http\Resources\OtterResource;

class Gender extends OtterResource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Gender';

    /**
     * The column of the model to display in select options
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * Get the fields and types used by the resource
     *
     * @return array
     */
    public static function fields()
    {
        return [
            'gender' => 'text',
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
                    'gender' => 'required|min:4',
                ],
                'update' => [
                    'gender' => 'required|min:4',
                ]
            ],
            'server' => [
                'create' => [
                    'gender' => 'required|min:4',
                ],
                'update' => [
                    'gender' => 'required|min:4',
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
        ];
    }
}