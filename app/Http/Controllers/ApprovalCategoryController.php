<?php

namespace App\Http\Controllers;

use App\Models\Master\ApprovalCategory;
use App\Repositories\ApprovalCategoryRepository;
use Illuminate\Http\Request;

class ApprovalCategoryController extends Controller
{
    private $title = 'Approval Category';
    private $approvalCategoryRepository;

    function __construct() {
        $this->approvalCategoryRepository = new ApprovalCategoryRepository();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
            'data'  => $this->approvalCategoryRepository->paginate(),
        ];

        return view('master.approval-category.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => $this->title,
        ];

        return view('master.approval-category.form', $data);
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
        ]);

        $this->approvalCategoryRepository->store($input);

        return redirect()->route('master.approval-category.index')->with([
            'status'  => 'success',
            'message' => 'Data has been saved successfully',
        ]);
    }

    public function edit($id)
    {
        $data = [
            'title'  => $this->title,
            'entity' => ApprovalCategory::findOrFail($id),
        ];

        return view('master.approval-category.form', $data);
    }

    public function update(Request $request)
    {
        $input = $request->validate([
            'name'        => 'required',
            'description' => 'nullable',
        ]);

        $this->approvalCategoryRepository->update($input, $request->id);

        return redirect()->route('master.approval-category.index')->with([
            'status'  => 'success',
            'message' => 'Data has been updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $this->approvalCategoryRepository->destroy($id);

        return redirect()->route('master.approval-category.index')->with([
            'status'  => 'success',
            'message' => 'Data has been deleted successfully',
        ]);
    }
}
