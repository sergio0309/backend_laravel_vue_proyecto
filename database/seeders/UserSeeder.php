<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $u1 = new User();
        $u1->name = "Admin";
        $u1->email = "admin@mail.com";
        $u1->password = bcrypt("admin54321");
        $u1->save();

        $u2 = new User();
        $u2->name = "Jose Gerente";
        $u2->email = "jose@mail.com";
        $u2->password = bcrypt("jose54321");
        $u2->save();

        $u3 = new User();
        $u3->name = "Pedro Cajero";
        $u3->email = "pedro@mail.com";
        $u3->password = bcrypt("pedro54321");
        $u3->save();
    }
}
