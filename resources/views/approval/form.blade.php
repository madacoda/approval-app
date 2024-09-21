@extends('layout.app')

@php
    $entity  = isset($entity) ? $entity : null;
    $is_show = Route::currentRouteName() == 'approval.show';
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
                            <a href="{{ route('approval.index') }}">
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
                    <form action="{{ $entity ? route('approval.update', $entity->id) : route('approval.store') }}" method="POST" id="approval-form">
                        @csrf
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="approval_category_id">Approval Category <span class="text-danger">*</span></label>
                                        <select class="form-select @error('approval_category_id') is-invalid @enderror" id="approval_category_id" name="approval_category_id" required @disabled($is_show)>
                                            <option value="">- Select Approval Category -</option>
                                            @foreach ($approval_categories as $approval_category)
                                                <option value="{{ $approval_category->id }}" @if(($entity?->approval_category_id == $approval_category->id) || old('approval_category_id') == $approval_category->id) selected @endif>
                                                    {{ $approval_category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('approval_category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="memo_number">Memo Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('memo_number') is-invalid @enderror" id="memo_number" name="memo_number" value="{{ $entity ? $entity->memo_number : old('memo_number') }}" @disabled($is_show)>
                                        @error('memo_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('status') is-invalid @enderror" id="status" name="status" value="{{ $entity ? $entity->status : 'progress' }}" readonly>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="unit">Unit <span class="text-danger">*</span></label>
                                        <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" @disabled($is_show)>
                                            <option value="">- Select Unit -</option>
                                            @foreach ($subdistricts as $subdistrict)
                                                <option value="{{ $subdistrict->subdistrict }}" @if(($entity?->unit == $subdistrict->subdistrict) || old('unit') == $subdistrict->subdistrict) selected @endif>{{ $subdistrict->subdistrict }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="area">Area <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ $entity ? $entity->area : old('area') }}" @disabled($is_show)>
                                        @error('area')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="consideration">Review <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('consideration') is-invalid @enderror" id="consideration" name="consideration" rows="3" @disabled($is_show)>{{ $entity ? $entity->consideration : old('consideration') }}</textarea>
                                        @error('consideration')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Name <span class="text-danger">*</span></th>
                                                <th>Employee Number <span class="text-danger">*</span></th>
                                                <th>Job Position <span class="text-danger">*</span></th>
                                                <th>New Job Position <span class="text-danger">*</span></th>
                                                <th>Effective Date <span class="text-danger">*</span></th>
                                                <th width="20px">New HB Distance <span class="text-danger">*</span></th>
                                                <th>Note</th>
                                                @if (!$entity)
                                                    <th>Action</th>
                                                @endif
                                                @if($is_show && auth()->user()->role->name == 'sdm')
                                                    <th class="text-center">Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($entity && count($entity->details) > 0)
                                                @if ($is_show)
                                                    @foreach ($entity->details as $item)
                                                        <tr>
                                                            <td class="text-center">1</td>
                                                            <td>
                                                                {{ $item->user->name }}
                                                            </td>
                                                            <td>
                                                                {{ $item->user->employee->employee_number }}
                                                            </td>
                                                            <td>
                                                                {{ $item->jobPosition?->name }}
                                                            </td>
                                                            <td>
                                                                {{ $item->newJobPosition?->name }}
                                                            </td>
                                                            <td>
                                                                {{ $item->effective_date }}
                                                            </td>
                                                            <td>
                                                                {{ $item->new_hb_distance }}
                                                            </td>
                                                            <td>
                                                                {{ $item->note }}
                                                            </td>
                                                            @if($is_show && auth()->user()->role->name == 'sdm')
                                                            <td class="text-center">
                                                                @if ($item->category)
                                                                    {{ $item->category?->name }}
                                                                @else
                                                                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" onclick="setModal({{ $item }})">Assign Type</button>
                                                                @endif
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @else
                                                <tr>
                                                    <td class="text-center align-middle">1</td>
                                                    <td>
                                                        <input type="text" class="form-control-plaintext @error('name.0') is-invalid @enderror" id="name_1" name="name[]" value="{{ $entity ? $entity->name : (is_array(old('name')) ? old('name')[0] : old('name')) }}">
                                                        @error('name.0')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select name="user_id[]" id="user_id_1" class="form-control @error('user_id.0') is-invalid @enderror"><option value="">- Select NIP -</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">
                                                                    {{ $user->employee->employee_number }} - {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('user_id.0')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control-plaintext" id="job_position_id_1_display" value="">
                                                        <input type="hidden" class="form-control-plaintext @error('job_position_id.0') is-invalid @enderror" id="job_position_id_1" name="job_position_id[]" value="{{ (is_array(old('job_position_id')) ? old('job_position_id')[0] : old('job_position_id')) }}">
                                                        @error('job_position_id.0')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select name="new_job_position_id[]" id="new_job_position_id_1" class="form-control @error('new_job_position_id.0') is-invalid @enderror">
                                                            <option value="">- Select New Job Position -</option>
                                                            @foreach ($job_positions as $job_position)
                                                                <option value="{{ $job_position->id }}">
                                                                    {{ $job_position->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('new_job_position_id.0')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control @error('effective_date.0') is-invalid @enderror" id="effective_date_1" name="effective_date[]" value="{{ $entity ? $entity->effective_date : (is_array(old('effective_date')) ? old('effective_date')[0] : old('effective_date'))  }}">
                                                        @error('effective_date.0')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control @error('new_hb_distance.0') is-invalid @enderror" id="hb_distance_1" name="new_hb_distance[]" value="{{ $entity ? $entity->new_hb_distance : (is_array(old('new_hb_distance')) ? old('new_hb_distance')[0] : old('new_hb_distance')) }}">
                                                        @error('new_hb_distance.0')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control @error('note.0') is-invalid @enderror" id="note_1" name="note[]" value="{{ $entity ? $entity->note : (is_array(old('note')) ? old('note')[0] : old('note')) }}">
                                                        @error('note.0')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    @if (!$is_show)
                                        <button type="button" id="add-row" class="btn btn-primary float-end mt-3">Add Employee</button>
                                    @endif
                                </div>
                            </div>

                            @if ($is_show)
                                <div class="row">
                                    <span class="text-center">Approval Workflow</span>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table align-middle">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Branch</th>
                                                    <th>Regional</th>
                                                    <th>Unit</th>
                                                    <th>Area</th>
                                                    <th>Date</th>
                                                    <th>Comment</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $current_approver_id = null;
                                                @endphp
                                                @foreach ($approval_workflows as $workflow)
                                                    @php
                                                        if(!$current_approver_id && $workflow->status == 'progress') {
                                                            $current_approver_id = $workflow->approver_module_id;
                                                        }
                                                    @endphp
                                                    <tr>

                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ $workflow->user->name }}</td>
                                                        <td>{{ $workflow->user->role->name }}</td>
                                                        <td>{{ $workflow->user->employee->branch ?? '-' }}</td>
                                                        <td>{{ $workflow->user->employee->regional ?? '-' }}</td>
                                                        <td>{{ $workflow->user->employee->unit ?? '-' }}</td>
                                                        <td>{{ $workflow->user->employee->area ?? '-' }}</td>
                                                        <td>{{ $workflow->updated_at }}</td>
                                                        <td>{{ $workflow->comment }}</td>
                                                        <td class="text-center">
                                                            @if ($current_approver_id == $workflow->approver_module_id)
                                                                <span class="badge bg-primary">Current Approver</span>
                                                            @else
                                                                @if($workflow->status == 'approved')
                                                                    <span class="badge bg-success">Approved</span>
                                                                @elseif($workflow->status == 'rejected')
                                                                    <span class="badge bg-danger">Rejected</span>
                                                                @elseif($workflow->status == 'progress')
                                                                    <span class="badge bg-warning">Pending</span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                 
                            @if (!$is_show)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="approver_id">Approver <span class="text-danger">*</span></label>
                                            <select class="form-select @error('approver_id') is-invalid @enderror" id="approver_id" name="approver_id" required>
                                                <option value="">- Select Approver KAB -</option>
                                                @foreach ($approvers as $approver)
                                                    <option value="{{ $approver->id }}" @if(old('approver_id') == $approver->id) selected @endif>{{ $approver->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('approver_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                            @if($is_show)
                                @if ($current_approver_id == auth()->user()->id && auth()->user()->role->name != 'sdm')
                                    <div class="mb-3">
                                        <label class="form-label" for="comment">Comment <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                    </div>

                                    <button class="btn btn-success" onclick="submitApproval('approved')" type="button">Approve</button>
                                    <button class="btn btn-danger" onclick="submitApproval('rejected')" type="button">Reject</button>
                                @endif

                                {{-- @if($current_approver_id == auth()->user()->id && auth()->user()->role->name == 'sdm')
                                    <button class="btn btn-primary btn-submit" type="submit">Submit SK</button>
                                    <a href="{{ route('approval.index') }}" class="btn btn-light">Cancel</a>
                                @endif --}}
                            @endif

                            @if(!$is_show)
                            <button class="btn btn-primary btn-submit" type="submit">Submit</button>
                            <a href="{{ route('approval.index') }}" class="btn btn-light">Cancel</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($is_show)
        <form action="{{ route('approval.approval', $entity->id) }}" method="POST" id="approval_form">
            @csrf
            <input type="hidden" name="status" value="">
            <input type="hidden" name="comment" id="comment">
        </form>

        <form action="{{ route('approval.assign-sk') }}" method="POST">
            @csrf
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Edit SK </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label" for="approval_category_id">Type <span class="text-danger">*</span></label>
                        <select class="form-control" name="approval_category_id" data-id="{{ $item->id }}" required> 
                            <option value="">- Assign Type SK -</option>
                            @foreach ($approval_categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="hidden" name="approval_detail_id" id="approval_detail_id" value="">
                    </div>
                    <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                    </div>
                </div>
                </div>
            </div>
        </form>
    @endif
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: '- Select NIP -',
            allowClear: true,
        });

        $('#unit').select2({
            placeholder: '- Select Unit -',
            allowClear: true,
        });

        // if ($('#unit').val()) {
        //     $('#unit').trigger('change');
        // }

        // Demo
        // $('#approval_category_id').val(1);
        // $('#approval_category_id').trigger('change');
        // $('#unit').val(1);
        // $('#unit').trigger('change');
        // $('#memo_number').val({{ date('YmdHis') }});
        // $('#area').val('Batuputih Laok 1');
        // $('#consideration').val('123');
    });
</script>

<script>
    $(document).ready(function () {
        let table = document.querySelector('.table-responsive tbody');
        let count = table.querySelectorAll('tr').length;

        $(document).on('change', 'select[name="user_id[]"]', function () {
            let userId = $(this).val();
            let user = @json($users);
            let id = $(this).attr('id');
            let number = id.split('_')[2];
            
            let selectedUser = user.find(u => u.id == userId);

            if (selectedUser) {
                console.log(number);
                $('#name_' + number).val(selectedUser.name);
                $('#job_position_id_' + number + '_display').val(selectedUser.employee?.job_position?.name);
                $('#job_position_id_' + number).val(selectedUser.employee?.job_position?.id);
            }
        });


        $('#add-row').on('click', function () {
            count++;
            var newRow =
            `<tr>
                <td class="text-center align-middle">${count}</td>
                <td>
                    <input type="text" class="form-control-plaintext" id="name_${count}" name="name[]" value="">
                </td>
                <td>
                    <select name="user_id[]" id="user_id_${count}" class="form-control" required>
                        <option value="">- Select NIP -</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->employee->employee_number }} - {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control-plaintext" id="job_position_id_${count}_display" value="" required>
                    <input type="hidden" class="form-control-plaintext @error('job_position_id.0') is-invalid @enderror" id="job_position_id_${count}" name="job_position_id[]" value="{{ (is_array(old('job_position_id')) ? old('job_position_id')[0] : old('job_position_id')) }}">
                </td>
                <td>
                    <select name="new_job_position_id[]" id="new_job_position_id_${count}" class="form-control" required>
                        <option value="">- Select New Job Position -</option>
                        @foreach ($job_positions as $job_position)
                            <option value="{{ $job_position->id }}">
                                {{ $job_position->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="date" class="form-control" id="effective_date_${count}" name="effective_date[]" value="" required>
                </td>
                <td>
                    <input type="text" class="form-control" id="hb_distance_${count}" name="new_hb_distance[]" value="" required>
                </td>
                <td>
                    <input type="text" class="form-control" id="note_${count}" name="note[]" value="">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                </td>
            </tr>
            `;
            $('tbody').append(newRow);
        });

        $(document).on('click', '.remove-row', function () {
            // count--;
            $(this).closest('tr').remove();
        });

        // $(document).on('click', '.btn-submit', function (event) {
        //     // if(event) event.preventDefault();
            
        //     var form = document.getElementById('approval-form');
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "Submit this data and process the approval?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Yes!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             form.submit();
        //         }
        //     });
        // });
    });

    function submitApproval(approval){
        if(event) {
            event.preventDefault();
        }

        const form = document.getElementById('approval_form');

        Swal.fire({
            title: 'Are you sure?',
            text: "This data will be " + approval + "!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                let comment = $('#comment').val();
                if(!comment) {
                    Swal.fire({
                        title: 'Comment is required!',
                        icon: 'warning',
                    });
                    return;
                }
                form.elements['status'].value = approval;
                form.elements['comment'].value = comment;
                form.submit();
            }
        });
    }

    // $('[name="approval_detail_category_id"]').on('change click', function() {
    //     let selectedValue = $(this).val();
    //     let itemId = $(this).data('id');
        
    //     let currentData = $('#approval_details').val() ? JSON.parse($('#approval_details').val()) : [];

    //     let existingItemIndex = currentData.findIndex(item => item.id === itemId);

    //     if (existingItemIndex !== -1) {
    //         currentData[existingItemIndex].value = selectedValue;
    //     } else {
    //         currentData.push({
    //             id: itemId,
    //             value: selectedValue
    //         });
    //     }

    //     $('#approval_details').val(JSON.stringify(currentData));

    //     console.log('Updated approval details:', currentData);
    // });


    function submitFinalApproval() {
        if(event) {
            event.preventDefault();
        }

        const form = document.getElementById('approval_form');

        Swal.fire({
            title: 'Are you sure?',
            text: "This data will be approved!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.elements['status'].value = 'approved';
                form.submit();
            }
        });
    }

    function setModal(item) {
        $('.modal-title').text('Edit SK ' + item.user.name + ' - ' + item.user.employee.employee_number);
        $('#approval_detail_id').val(item.id);
    }
</script>
@endpush
