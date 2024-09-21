<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Repositories\EmployeeRepository;
use App\Repositories\JobPositionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SubdistrictRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $title = 'User';
    private $userRepository;
    private $roleRepository;
    private $jobPositionRepository;
    private $employeeRepository;
    private $subdistrictRepository;

    function __construct()
    {
        $this->userRepository        = new UserRepository();
        $this->roleRepository        = new RoleRepository();
        $this->jobPositionRepository = new JobPositionRepository();
        $this->employeeRepository    = new EmployeeRepository();
        $this->subdistrictRepository = new SubdistrictRepository();
    }

    function index()
    {
        $data = [
            'title' => $this->title,
            'data'  => $this->userRepository->paginate(),
        ];

        return view('user.index', $data);
    }

    function create()
    {
        $data = [
            'title'         => $this->title,
            'roles'         => $this->roleRepository->all(),
            'job_positions' => $this->jobPositionRepository->all(),
            'subdistricts'  => $this->subdistrictRepository->all(),
        ];

        return view('user.form', $data);
    }

    function store(Request $request)
    {
        $request->validate([
            'name'            => 'required',
            'email'           => 'required|email|unique:users',
            'password'        => 'required',
            'role_id'         => 'required',
            'employee_number' => 'required|unique:employees',
            'identity_number' => 'required|unique:employees',
            'job_position_id' => 'nullable',
            'area'            => 'nullable',
            'hb_distance'     => 'nullable',
            'unit'            => 'nullable',
        ]);

        $input_user = $request->only([
            'name',
            'email',
            'password',
            'role_id',
        ]);
        $input_user['password'] = bcrypt($input_user['password']);

        $input_employee = $request->only([
            'job_position_id',
            'employee_number',
            'identity_number',
            'hb_distance',
            'unit',
            'area'
        ]);

        DB::beginTransaction();
        $user                      = $this->userRepository->store($input_user);
        $input_employee['user_id'] = $user->id;
        $this->employeeRepository->store($input_employee);
        DB::commit();

        return redirect()->route('user.index')->with([
            'status'  => 'success',
            'message' => 'Data has been saved successfully',
        ]);
    }

    function edit($id)
    {
        $data = [
            'title'         => $this->title,
            'entity'        => $this->userRepository->find($id),
            'roles'         => $this->roleRepository->all(),
            'job_positions' => $this->jobPositionRepository->all(),
            'subdistricts'  => $this->subdistrictRepository->all(),
        ];

        return view('user.form', $data);
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'name'            => 'required',
            'email'           => 'required|email|unique:users,email,' . $id,
            'password'        => 'nullable',
            'role_id'         => 'required',
            'employee_number' => 'required|unique:employees,employee_number,' . $id,
            'identity_number' => 'required|unique:employees,identity_number,' . $id,
            'job_position_id' => 'nullable',
            'area'            => 'nullable',
            'hb_distance'     => 'nullable',
            'unit'            => 'nullable',
        ]);

        $input_user = $request->only([
            'name',
            'email',
            'password',
            'role_id',
            'job_position_id',
        ]);
        if($input_user['password']) {
            $input_user['password'] = bcrypt($input_user['password']);
        } else {
            unset($input_user['password']);
        }

        $input_employee = $request->only([
            'employee_number',
            'identity_number',
            'hb_distance',
            'unit',
            'area'
        ]);

        DB::beginTransaction();
        $this->userRepository->update($input_user, $id);
        $this->employeeRepository->update($input_employee, $id);
        DB::commit();

        return redirect()->route('user.index')->with([
            'status'  => 'success',
            'message' => 'Data has been updated successfully',
        ]);
    }

    function destroy($id)
    {
        DB::beginTransaction();
        Employee::where('user_id', $id)->delete();
        User::where('id', $id)->delete();
        DB::commit();

        return redirect()->route('user.index')->with([
            'status'  => 'success',
            'message' => 'Data has been deleted successfully',
        ]);
    }
}
