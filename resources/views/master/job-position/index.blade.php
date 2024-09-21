@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>{{ $title }} List</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">{{ $title }} List</li>
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
                        <a href="{{ route('master.job-position.create') }}">
                            <div class="btn btn-primary float-end"><i class="fa fa-plus-square"></i> Create</div>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->description ?? '-' }}</td>
                                        <td>{{ $d->createdBy->name ?? '-' }}</td>
                                        <td>{{ $d->updatedBy->name ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('master.job-position.edit', ['id' => $d->id]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</button>
                                            </a>
                                            <x-forms.actions.delete :url="route('master.job-position.delete', $d->id)" :id="$d->id" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
