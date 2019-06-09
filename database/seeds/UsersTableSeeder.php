<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin                      = new \App\User();
        $admin->name                = "Adminus";
        $admin->lastname            = "Administratus";
        $admin->birthdate           = \Carbon\Carbon::now()->toDateString();
        $admin->gender              = \App\Gender::first()->id;
        $admin->email               = "admin@admin.admin";
        $admin->admin               = true;
        $admin->password            = \Illuminate\Support\Facades\Hash::make("admin");
        $admin->save();

//        factory(App\User::class, 50)->create();
        factory(App\User::class, 50)->create()->each(function ($user) {
            $user->statuses()->save(factory(App\Status::class)->make());
            $user->statuses()->save(factory(App\Status::class)->make());
        });

    }
}