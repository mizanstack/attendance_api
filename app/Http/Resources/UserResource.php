<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array =  parent::toArray($request);
        $array['avatar_src'] = url('/') . '/uploads/users/' . $this->avatar;
        $array['role_name'] = $this->role == 1 ? 'Admin' : 'Member';

        if(!$this->leave_date){
            $array['employee_status'] = 'Employed';
        } else {
            $date_now = date("Y-m-d");
            $array['employee_status'] = $date_now > $this->leave_date ? 'Left' : 'Employed';
        }
        return $array;
    }
}
