<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use \Spatie\Permission\Traits\HasRoles;




class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,HasRoles ;
  

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function deleteUser($id){
            $user = User::find($id);
            if ($user) {
                $user->delete();
                return 1; // Deletion successful
            } else {
                return 0; // User not found
            }
    
    }
    public static function EditUser($id){
        $user = User::find($id);
        if ($user) {
            
            return $user; // Deletion successful
        } else {
            return 0; // User not found
        }

    }
    public static function singleUserDetails($id){
        $userData = User::find($id);
        if($userData){
            return $userData;
        }else{
            return 0;
        }
    }
    public static function EditSingleUserDetails($data){
       
        $user = User::find($data['id']);
        if ($user) {
            try {
                $user->update([
                    'name' => $data['name'],
                    // Add other fields to update as needed
                ]);
                return "saved";
            } catch (\Exception $e) {
                // Log the error or handle it as needed
                return "An error occurred: " . $e->getMessage();
            }
        } else {
            return "User not found";
        }
    }



   
}
