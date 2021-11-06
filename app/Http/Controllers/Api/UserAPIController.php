<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest ;
use Response;
use DB;



class UserAPIController extends AppBaseController
{

    public function index(Request $request)
    {
        $users = User::all();
        return UserResource::collection($users);

        // return $this->sendResponse($directories->toArray(), 'Directories retrieved successfully');
    }


    public function show(Request $request)
    {
        $user = User::find($request->id);

        return new UserResource($user);

        // return $this->sendResponse($directories->toArray(), 'Directories retrieved successfully');
    }



    public function store(CreateUserAPIRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = new User;
            $user->role = $request->role;
			$user->name = $request->first_name . ' ' . $request->last_name;
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->email = $request->email;
			$user->password = bcrypt($request->password);
			$user->entry_date = $request->entry_date;
			$user->avatar = $user->uploadFileVue('avatar', $request->first_name);
			$user->leave_date = $request->leave_date;
			$user->save();
            DB::commit();

            return $this->sendResponse($user->toArray(), 'User saved successfully');

        } catch (\Throwable $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }




    public function update(UpdateUserAPIRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            
            $user = User::find($id);
            $user->role = $request->role;
			$user->name = $request->first_name . ' ' . $request->last_name;
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;

            if($request->email){
    			$user->email = $request->email;
            }
            if($request->password){
    			$user->password = bcrypt($request->password);
            }
			$user->entry_date = $request->entry_date;

            if($request->avatar){
    			$user->avatar = $this->uploadFileVue($request->avatar);
            }
			$user->leave_date = $request->leave_date;
			$user->save();
            DB::commit();

            return $this->sendResponse($user->toArray(), 'User Update successfully');

        } catch (\Throwable $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if (empty($user)) {
                return $this->sendError('User not found');
            }
            \App\Models\Attend::where('user_id', $id)->delete();
            $user->delete();

            DB::commit();
            return $this->sendSuccess('User deleted successfully');


        } catch (\Throwable $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }


        
    }
}
