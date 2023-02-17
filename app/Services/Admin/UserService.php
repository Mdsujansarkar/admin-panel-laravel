<?php 
declare(strict_types=1);

namespace App\Services\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser( $data ): User
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
        if (!empty($data->roles)) {
            $user->assignRole($data->roles);
        }
        return $data;
    }
    public function assignRole( $data, User $user): void 
    {
        $roules = $data->roles ?? [];
        $user->assignRole($roules);
    }
}