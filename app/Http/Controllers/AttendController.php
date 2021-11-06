<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttendRequest;
use App\Http\Requests\UpdateAttendRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Attend;
use Illuminate\Http\Request;
use Flash;
use Response;

class AttendController extends AppBaseController
{
    /**
     * Display a listing of the Attend.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Attend $attends */
        $attends = Attend::all();

        return view('admin.attends.index')
            ->with('attends', $attends);
    }

    /**
     * Show the form for creating a new Attend.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.attends.create');
    }

    /**
     * Store a newly created Attend in storage.
     *
     * @param CreateAttendRequest $request
     *
     * @return Response
     */
    public function store(CreateAttendRequest $request)
    {
        $input = $request->all();

        /** @var Attend $attend */
        $attend = Attend::create($input);

        Flash::success('Attend saved successfully.');

        return redirect(route('admin.attends.index'));
    }

    /**
     * Display the specified Attend.
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
            Flash::error('Attend not found');

            return redirect(route('admin.attends.index'));
        }

        return view('admin.attends.show')->with('attend', $attend);
    }

    /**
     * Show the form for editing the specified Attend.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Attend $attend */
        $attend = Attend::find($id);

        if (empty($attend)) {
            Flash::error('Attend not found');

            return redirect(route('admin.attends.index'));
        }

        return view('admin.attends.edit')->with('attend', $attend);
    }

    /**
     * Update the specified Attend in storage.
     *
     * @param int $id
     * @param UpdateAttendRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttendRequest $request)
    {
        /** @var Attend $attend */
        $attend = Attend::find($id);

        if (empty($attend)) {
            Flash::error('Attend not found');

            return redirect(route('admin.attends.index'));
        }

        $attend->fill($request->all());
        $attend->save();

        Flash::success('Attend updated successfully.');

        return redirect(route('admin.attends.index'));
    }

    /**
     * Remove the specified Attend from storage.
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
            Flash::error('Attend not found');

            return redirect(route('admin.attends.index'));
        }

        $attend->delete();

        Flash::success('Attend deleted successfully.');

        return redirect(route('admin.attends.index'));
    }
}
