<?php

namespace App\Http\Controllers;

use App\Models\Master\JobPosition;
use App\Repositories\JobPositionRepository;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{

    private $title = 'Job Position';
    private $jobRepository;

    function __construct()
    {
        $this->jobRepository = new JobPositionRepository();
    }

    function index()
    {
        $data = [
            'title' => $this->title,
            'data'  => $this->jobRepository->paginate(),
        ];

        return view('master.job-position.index', $data);
    }

    function create()
    {
        $data = [
            'title' => $this->title,
        ];

        return view('master.job-position.form', $data);
    }

    function store(Request $request)
    {
        $input = $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
        ]);

        JobPosition::create($input);

        return redirect()->route('master.job-position.index')->with([
            'status'  => 'success',
            'message' => 'Data has been saved successfully',
        ]);
    }

    function edit($id)
    {
        $data = [
            'title'  => $this->title,
            'entity' => JobPosition::findOrFail($id),
        ];

        return view('master.job-position.form', $data);
    }

    function update(Request $request, $id)
    {
        $input = $request->validate([
            'name'        => 'required',
            'description' => 'required',
        ]);

        $jobPosition         = JobPosition::findOrFail($id);
        $jobPosition->update($input);

        return redirect()->route('master.job-position.index')->with([
            'status'  => 'success',
            'message' => 'Data has been updated successfully',
        ]);
    }

    function destroy($id)
    {
        $jobPosition = JobPosition::findOrFail($id);
        $jobPosition->delete();

        return redirect()->route('master.job-position.index')->with([
            'status'  => 'success',
            'message' => 'Data has been deleted successfully',
        ]);
    }
}
