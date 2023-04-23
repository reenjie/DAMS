<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Agreement;
use App\Models\Email;
use Illuminate\Support\Facades\Hash;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        
        User::create([
            'name' =>'Administrator',
            'email' =>'admin@admin.com',
            'password'=> Hash::make('password'),
            'address' =>'fakeaddress',
            'contactno'=>'00000',
            'user_type' =>'superadmin',
            'fl'=>0,
            'otp'=>0,
            'designation'=>'admin',
             ]);

        Email::create([
            'email'=>'noreplymedicalclinic@gmail.com',
            'name' =>'Online Doctor Appointment MS',
            'token' => '1//0e8Oo6ZeAN33qCgYIARAAGA4SNwF-L9IrrriLXUCpHHBtuRXoQiJputY9_EzfSdsB5xNRHPt8BqUnU3zxxJzi1Ly4nKf20Hr3JKQ',
        ]);

        Agreement::create([
            'content'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        ]);
    }
}
