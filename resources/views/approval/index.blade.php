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
                        @if (auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'kum')
                            <a href="{{ route('approval.create') }}">
                                <div class="btn btn-primary float-end"><i class="fa fa-plus-square"></i> Create</div>
                            </a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Memo Number</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Unit & Area</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $d->memo_number }}</td>
                                        <td class="text-uppercase">{!! status_badge($d->status) !!}</td>
                                        <td>{{ $d->category->name ?? '-' }}</td>
                                        <td>{{ $d->unit . ' - ' . $d->area }}</td>
                                        <td>{{ $d->createdBy->name ?? '-' }}</td>
                                        <td>{{ $d->updatedBy->name ?? '-' }}</td>
                                        <td class="text-center">
                                            {{-- <a href="{{ route('approval.edit', ['id' => $d->id]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</button>
                                            </a> --}}
                                            <a href="{{ route('approval.show', ['id' => $d->id]) }}">
                                                <button class="btn btn-info"><i class="fa fa-eye"></i> View</button>
                                            </a>
                                            @if (auth()->user()->role->name == 'admin')
                                                @if ($d->status != 'done')
                                                    <x-forms.actions.delete :url="route('approval.delete', $d->id)" :id="$d->id" />
                                                @endif
                                            @endif
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
