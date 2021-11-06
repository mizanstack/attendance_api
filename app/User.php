<?php

namespace App;

use App\Traits\ImageTrait;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, ImageTrait;
    use ImageTrait {
        deleteImage as traitDeleteImage;
    }
    use HasRoles;

    public $table = 'users';
    const IMAGE_PATH = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $upload_path = 'uploads/users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role',
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'entry_date',
        'avatar',
        'leave_date',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'set_password'      => 'boolean',
        'image_path'      => 'string',
    ];


    public static $rules = [
        'role' => 'required',
        'name' => '',
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => "required|unique:users,email",
        'password' => 'required',
        'entry_date' => 'required',
        'avatar' => 'image|mimes:jpg,jpeg,png,gif',
        'leave_date' => '',
        'status' => '',
    ];

    public static $rules_update = [
        'role' => 'required',
        'name' => '',
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => "unique:users,email",
        'entry_date' => 'required',
        'avatar' => 'image|mimes:jpg,jpeg,png,gif',
        'leave_date' => '',
        'status' => '',
    ];

    public function scopeWithSearch($query){
        $keyword = request()->keyword;
        $search_fields = $this->search_fields;
        // dd($search_fields);

        if(request('keyword')){
            if(count($search_fields)){
                foreach ($search_fields as $field) {
                    $query = $query->orWhere( $field, 'like', '%' . $keyword . '%');
                }
            }
        }
        return $query;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getImagePathAttribute($value)
    {
        if (!empty($value)) {
            return $this->imageUrl(self::IMAGE_PATH.DIRECTORY_SEPARATOR.$value);
        }

        return getUserImageInitial($this->id, $this->name);
    }

    /**
     * @return bool
     */
    public function deleteImage()
    {
        $image = $this->getOriginal('image_path');
        if (empty($image)) {
            return true;
        }

        return $this->traitDeleteImage(self::IMAGE_PATH.DIRECTORY_SEPARATOR.$image);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    } 

    public function uploadFileVue($field_or_field_with_request, $save_title='', $path=null, $request_method = false){
        // return($field);
        $path = $path ? $path : $this->upload_path;

        $has_profile_photo = $request_method ? $field_or_field_with_request : request($field_or_field_with_request);

        if($has_profile_photo){
            $extension = $has_profile_photo->getClientOriginalExtension(); // getting image extension
            $filename =  remove_space_dots_replace_underscore($save_title) . '_' . time() . mt_rand(1000, 9999) . '.'.$extension;

            // \Image::make($has_profile_photo)->save(public_path($path).$filename);

            request($field_or_field_with_request)->move(public_path($path), $filename);

            return $filename;
        }
        return null;
    }
}
