<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\ApprovalDetail;
use App\Models\ApprovalWorkflow;
use App\Models\Master\JobPosition;
use App\Models\User;
use App\Repositories\ApprovalCategoryRepository;
use App\Repositories\ApprovalRepository;
use App\Repositories\ApprovalWorkflowRepository;
use App\Repositories\SubdistrictRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    private $title = 'Approval';
    private $approvalRepository;
    private $approvalCategoryRepository;
    private $subdistrictRepository;
    private $approvalWorkflowRepository;
    private $userRepository;

    public function __construct()
    {
        $this->approvalRepository         = new ApprovalRepository();
        $this->approvalCategoryRepository = new ApprovalCategoryRepository();
        $this->subdistrictRepository      = new SubdistrictRepository();
        $this->userRepository             = new UserRepository();
        $this->approvalWorkflowRepository = new ApprovalWorkflowRepository();

    }

    function index() {
        $data = [
            'title' => $this->title,
            'data'  => $this->approvalRepository->paginate(),
        ];

        return view('approval.index', $data);
    }

    function create() {
        $data = [
            'title'               => $this->title,
            'approval_categories' => $this->approvalCategoryRepository->all(),
            'subdistricts'        => $this->subdistrictRepository->all(),
            'users'               => User::with('employee.jobPosition')->where('role_id', 2)->get(),
            'job_positions'       => JobPosition::all(),
            'approvers'           => User::where('role_id', 4)->get(),
        ];

        return view('approval.form', $data);
    }

    function store(Request $request) {
        $request->validate([
            'approval_category_id'  => 'required',
            'memo_number'           => 'required',
            'unit'                  => 'required',
            'area'                  => 'required',
            'consideration'         => 'required',
            'status'                => 'required',
            'name.*'                => 'required|string',
            'user_id.*'             => 'required|integer',
            'job_position_id.*'     => 'required|string',
            'new_job_position_id.*' => 'required|integer',
            'effective_date.*'      => 'required|date',
            'new_hb_distance.*'     => 'required|string',
            'note.*'                => 'nullable|string',
            'approver_id'           => 'required|integer',
            $request->validate([
                'user_id' => [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (count($value) !== count(array_unique($value))) {
                            $fail('The '.$attribute.' contains duplicate values.');
                        }
                    },
                ],
                'user_id.*' => 'required|integer',
            ]),
        ]);

        $input = $request->only([
            'approval_category_id',
            'memo_number',
            'unit',
            'area',
            'consideration',
            'status',
        ]);
        $input['created_by'] = auth()->user()->id;

        $input_details = [];

        foreach ($request->name as $index => $name) {
            $input_details[] = [
                'name'                => $name,
                'user_id'             => $request->user_id[$index],
                'job_position_id'     => $request->job_position_id[$index],
                'new_job_position_id' => $request->new_job_position_id[$index],
                'effective_date'      => $request->effective_date[$index],
                'new_hb_distance'     => $request->new_hb_distance[$index],
                'note'                => $request->note[$index],
            ];
        }

        $approver_id = $request->approver_id;

        DB::beginTransaction();
        $approval = Approval::create($input);
        foreach($input_details as $input_detail) {
            $input_detail['approval_id'] = $approval->id;
            ApprovalDetail::create($input_detail);
        }
        $this->approvalWorkflowRepository->generate('approval', $approval->id, [
            'user_id'         => $approver_id,
            'sequence_number' => 1,
        ]);
        DB::commit();

        return redirect()->route('approval.index')->with([
            'status'  => 'success',
            'message' => 'Data has been saved successfully',
        ]);
    }

    function edit(int $id) {
        $data = [
            'title'               => $this->title,
            'approval_categories' => $this->approvalCategoryRepository->all(),
            'subdistricts'        => $this->subdistrictRepository->all(),
            'users'               => User::with('employee.jobPosition')->where('role_id', 2)->get(),
            'job_positions'       => JobPosition::all(),
            'approvers'           => User::where('role_id', 4)->get(),
            'entity'              => $this->approvalRepository->find($id),
        ];

        return view('approval.form', $data);
    }

    function show(int $id) {
        $data = [
            'title'               => $this->title,
            'approval_categories' => $this->approvalCategoryRepository->all(),
            'subdistricts'        => $this->subdistrictRepository->all(),
            'users'               => User::with('employee.jobPosition')->where('role_id', 2)->get(),
            'job_positions'       => JobPosition::all(),
            'approvers'           => User::where('role_id', 4)->get(),
            'entity'              => $this->approvalRepository->find($id),
            'is_show'             => true,
            'approval_workflows'  => ApprovalWorkflow::where('module', 'approval')->where('module_id', $id)->orderBy('sequence_number', 'asc')->get(),
        ];

        return view('approval.form', $data);
    }

    function destroy(int $id) {
        $this->approvalRepository->destroy($id);

        return redirect()->route('approval.index')->with([
            'status'  => 'success',
            'message' => 'Data has been deleted successfully',
        ]);
    }

    function approval(Request $request, int $id) {
        $request->validate([
            'status'  => 'required',
            'comment' => 'required',
        ]);

        $approval_workflow = ApprovalWorkflow::where('module', 'approval')->where('module_id', $id)->where('status', 'progress')->orderBy('sequence_number', 'asc')->first();
        if($approval_workflow->approver_module_id != auth()->user()->id) {
            return redirect()->route('approval.show', $id)->with([
                'status'  => 'error',
                'message' => 'You are not current approver!',
            ]);
        }

        DB::beginTransaction();
        $approval_workflow->update([
            'status'  => $request->status,
            'comment' => $request->comment,
        ]);
        $approval_workflow->save();

        // $approval = Approval::find($id);
        // $approval->status = $request->status;
        // $approval->save();
        DB::commit();

        return redirect()->route('approval.show', $id)->with([
            'status'  => 'success',
            'message' => 'Data has been ' . $request->status . ' successfully',
        ]);
    }

    function assignSk(Request $request) {
        $request->validate([
            'approval_detail_id'   => 'required|integer',
            'approval_category_id' => 'required|integer',
        ]);

        DB::beginTransaction();
        $approval_detail = ApprovalDetail::find($request->approval_detail_id);
        $approval_detail->approval_category_id = $request->approval_category_id;
        $approval_detail->save();

        $is_final = true;
        $approval_details = $approval_detail->approval->details;
        foreach($approval_details as $detail) {
            if(!$detail->approval_category_id) {
                $is_final = false;
                break;
            }
        }

        if($is_final) {
            $approval = $approval_detail->approval;
            $approval->status = 'done';
            $approval->save();

            $approval_workflow = ApprovalWorkflow::where('module', 'approval')->where('module_id', $approval->id)->where('status', 'progress')->orderBy('sequence_number', 'asc')->first();
            if($approval_workflow->approver_module_id != auth()->user()->id) {
                return redirect()->route('approval.show', $approval->id)->with([
                    'status'  => 'error',
                    'message' => 'You are not current approver!',
                ]);
            }

            $approval_workflow->update([
                'status'  => 'approved',
                'comment' => 'SK has been assigned',
            ]);
            $approval_workflow->save();

            foreach($approval_details as $detail) {
               $employee_update_inputs = [
                    'job_position_id' => $detail->new_job_position_id,
                    'hb_distance'     => $detail->new_hb_distance,
                ];
                $employee = $detail->user->employee;
                $employee->update($employee_update_inputs);
            }
        }
        DB::commit();

        return redirect()->route('approval.show', $approval_detail->approval_id)->with([
            'status'  => 'success',
            'message' => 'Data has been saved successfully',
        ]);
    }
}
