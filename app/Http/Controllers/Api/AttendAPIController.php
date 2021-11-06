<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAttendAPIRequest;
use App\Http\Requests\API\UpdateAttendAPIRequest;
use App\Models\Attend;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AttendResource;
use Response;
use DB;

/**
 * Class AttendController
 * @package App\Http\Controllers\API
 */

class AttendAPIController extends AppBaseController
{

    /**
     * Display a listing of the Attend for a user by a month
     * GET|HEAD /attends
     *
     * @param Request $request
     * @return Response
     */
    public function get($user_id, $year, $month, Request $request)
    {
        $query = Attend::query();
        $query->where('user_id', $user_id)->where('year', $year)->where('month', $month);
        $result = $query->get();
        return AttendResource::collection($result);
        return $this->sendResponse($result->toArray(), 'Attend retrieved by month successfully');

    }



    /**
     * Display a listing of the Attend.
     * GET|HEAD /attends
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Attend::query();
        $attends = $query->paginate(30);
        return AttendAPIResource::collection($attends);

    }

    /**
     * Store a newly created Attend in storage.
     * POST /attends
     *
     * @param CreateAttendAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAttendAPIRequest $request)
    {

        try {
            DB::beginTransaction();

            $attend = Attend::updateOrCreate(
                [
                   'user_id'   => $request->user_id,
                   'year'   => $request->year,
                   'month'   => $request->month,
                   'day'   => $request->day,
                ],
                [
                    $request->key => $request->value
                ],
            );

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Created successfully']);
       }
       catch( \Execption $e ) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something wrong']);
       }
    }


    /**
     * Reset an created Attend in storage.
     * POST /attends
     *
     * @param ResetAttendAPIRequest $request
     *
     * @return Response
     */
    public function reset(CreateAttendAPIRequest $request)
    {

        try {
            DB::beginTransaction();

            $attend = Attend::where(
                [
                   'user_id'   => $request->user_id,
                   'year'   => $request->year,
                   'month'   => $request->month,
                   'day'   => $request->day,
                ])->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'deleted successfully']);
       }
       catch( \Execption $e ) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something wrong']);
       }
    }

    /**
     * Display the specified Attend.
     * GET|HEAD /attends/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Attend $attend */
        $attend = Attend::find($id);

        if (empty($attend)) {
            return $this->sendError('Attend not found');
        }

        return $this->sendResponse($attend->toArray(), 'Attend retrieved successfully');
    }

    /**
     * Update the specified Attend in storage.
     * PUT/PATCH /attends/{id}
     *
     * @param int $id
     * @param UpdateAttendAPIRequest $request
     *
     * @return Response
     */
    public function update($user_id, $year, $month, $day, Request $request)
    {
        try {
            DB::beginTransaction();

            $attend = Attend::updateOrCreate(
                [
                   'user_id'   => $user_id,
                   'year'   => $year,
                   'month'   => $month,
                   'day'   => $day,
                ],
                [
                    'start_work_time' => $request->start_work_time,
                    'end_work_time' => $request->end_work_time,
                    'start_break_time' => $request->start_break_time,
                    'end_break_time' => $request->end_break_time,
                    'memo' => $request->memo,
                ],
            );
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Updated successfully']);
       }
       catch( \Execption $e ) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something wrong']);
       }
    }

    /**
     * Remove the specified Attend from storage.
     * DELETE /attends/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Attend $attend */
        $attend = Attend::find($id);

        if (empty($attend)) {
            return $this->sendError('Attend not found');
        }

        $attend->delete();

        return $this->sendSuccess('Attend deleted successfully');
    }
}
