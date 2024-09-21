@extends('layout.app')

@php
    $entity = isset($entity) ? $entity : null;
@endphp
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>{{ $entity ? "Edit $title" : "Create $title" }}</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.index') }}">
                                {{ $title }} List
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $entity ? "Edit $title" : "Create $title" }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Form {{ $title }}</h5>
                    </div>
                    <form action="{{ $entity ? route('user.update', $entity->id) : route('user.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Input name" value="{{ $entity ? $entity->name : old('name')  }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="Input email" value="{{ $entity ? $entity->email : old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="Input password" @if(!$entity) required @endif>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="role_id">Role</label>
                                        <select class="text-uppercase form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id">
                                            <option value="">- Select Role -</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" @if(($entity?->role_id == $role->id) || old('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="identity_number">Identity Number</label>
                                        <input class="form-control @error('identity_number') is-invalid @enderror" id="identity_number" name="identity_number" type="text" placeholder="Input identity number" value="{{ $entity ? $entity->employee->identity_number : old('identity_number') }}" required>
                                        @error('identity_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="employee_number">Employee Number</label>
                                        <input class="form-control @error('employee_number') is-invalid @enderror" id="employee_number" name="employee_number" type="text" placeholder="Input employee number" value="{{ $entity ? $entity->employee->employee_number : old('employee_number') }}" required>
                                        @error('employee_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="job_position_id">Job position</label>
                                        <select class="form-select @error('job_position_id') is-invalid @enderror" id="job_position_id" name="job_position_id">
                                            <option value="">- Select Job Position -</option>
                                            @foreach ($job_positions as $job_position)
                                                <option value="{{ $job_position->id }}" @if(($entity?->employee?->jobPosition?->id == $job_position->id) || old('job_position') == $job_position->id) selected @endif>{{ $job_position->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('job_position_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="unit">Unit</label>
                                        <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit">
                                            <option value="">- Select Unit -</option>
                                            @foreach ($subdistricts as $subdistrict)
                                                <option value="{{ $subdistrict->subdistrict }}" @if(($entity?->employee?->unit == $subdistrict->subdistrict) || old('subdistrict') == $subdistrict->subdistrict) selected @endif>{{ $subdistrict->subdistrict }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="area">Area</label>
                                        <input class="form-control @error('area') is-invalid @enderror" id="area" name="area" type="text" placeholder="Input area" value="{{ $entity?->employee?->area ?? old('area') }}">
                                        @error('area')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="hb_distance">HB Distance</label>
                                        <input class="form-control @error('hb_distance') is-invalid @enderror" id="hb_distance" name="hb_distance" type="text" placeholder="Input hb distance" value="{{ $entity?->employee?->hb_distance ?? old('hb_distance') }}">
                                        @error('hb_distance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <input class="btn btn-light" type="reset" value="Cancel">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#unit').select2({
            placeholder: '- Select Unit -',
            allowClear: true
        });
    });
</script>
@endpush
