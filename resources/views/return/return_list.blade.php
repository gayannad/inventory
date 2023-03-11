@extends('admin_template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title text-info text-uppercase">
                            Return Note List
                        </div>
                        <div class="text-info text-uppercase">
                            <a href="/return/new-return" target="_self">
                                <button type="button" class="btn btn-success btn-sm float-right">
                                    <i class="fa fa-plus">
                                        New Return
                                    </i>
                                </button>
                            </a>
                        </div>
                    </div>
                    @if (session('alert'))
                        <div class="alert alert-success">
                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-hidden="true">
                            </button>
                            {{ session('alert') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('srn.search') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <input type="search" class="form-control" name="search" placeholder="Enter Return No">
                                </div>
                                <div class="col-md-2">
                                    <select name="supplier" id="supplier" class="form-control">
                                        <option value="" selected disabled>Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="options" id="options" class="form-control">
                                        <option value="" selected disabled>Pending/Approved/Rejected</option>
                                        <option value="1">PENDING</option>
                                        <option value="2">APPROVED</option>
                                        <option value="3">REJECTED</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control"
                                           name="created_at" id="created_at">
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary btn-sm float-left">
                                        <i class="fa fa-search">Search</i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="form-group row">
                            <table class="table table-borderless table-responsive-lg">
                                <thead class="bg-gradient-navy">
                                <tr class="text-uppercase">
                                    <th class="text-center">Return No</th>
                                    <th class="text-center">Supplier</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody class="bg-light">
                                @foreach ($srns as $srn)
                                    <tr>
                                        <td class="text-center">{{ $srn->id }}</td>
                                        <td class="text-center">{{ $srn->suppliers->company_name }}</td>
                                        <td class="text-center">{{ $srn->created_at }}</td>
                                        <td class="text-center">
                                            @if ($srn->status == \App\ReturnHeader::RETURN_PENDING)
                                                <span class="badge badge-pill badge-primary font-weight-bold">PENDING</span>
                                            @endif
                                            @if ($srn->status == \App\ReturnHeader::RETURN_APPROVED)
                                                <span class="badge badge-pill badge-success font-weight-bold">APPROVED</span>
                                            @endif
                                            @if ($srn->status == \App\ReturnHeader::RETURN_REJECTED)
                                                <span class="badge badge-pill badge-danger font-weight-bold">REJECTED</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="/return/return-view/{{ $srn->id }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-eye">View</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop