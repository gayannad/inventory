<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 5/30/18
 * Time: 11:24 AM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container-fluid">
        <div class="card">

            <div class="card-body">
                <form action="/supplier/search" method="post">
                    <div class="form-group row">
                        {{csrf_field()}}
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="search" placeholder="SEARCH">
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary btn-sm float-left"><i class="fa fa-search">Search</i>
                            </button>
                        </div>
                    </div>
                </form>
                @if (session('alert'))
                    <div class="alert alert-success">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true">&times;
                        </button>
                        {{ session('alert') }}
                    </div>
                @endif
                <div class="form-group row">
                    @if(isset($suppliers))
                        <table class="table table-bordered table-responsive-lg">
                            <thead class="">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Contact person</th>
                                <th>Telephone</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($suppliers as $key=> $supplier)

                                <tr>
                                    <td>{{$supplier->id}}</td>
                                    <td>{{$supplier->comapany_name}}</td>
                                    <td>{{$supplier->contact_person}}</td>
                                    <td>{{$supplier->telephone}}</td>
                                    <td>{{$supplier->email}}</td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal"
                                                data-target="#supplierModal_{{$key}}"
                                                data-whatever="@mdo" id="view_{{$key}}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="supplierModal_{{$key}}" tabindex="-1" role="dialog"
                                     aria-labelledby="supplierModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="/supplier/update" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Supplier</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Name:</label>
                                                        <input type="text" class="form-control"
                                                               name="name"
                                                               id="name_{{$key}}"
                                                               value="{{$supplier->comapany_name}}" required>
                                                        <input type="hidden" name="id" value="{{$supplier->id}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Contact
                                                            person:</label>
                                                        <input type="text" class="form-control" id="contact_person" name="contact_person"
                                                               value="{{$supplier->contact_person}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name"
                                                               class="col-form-label">Telephone:</label>
                                                        <input type="number" class="form-control" id="telephone" name="telephone"
                                                               value="{{$supplier->telephone}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name"
                                                               class="col-form-label">Mobile:</label>
                                                        <input type="number" class="form-control" id="mobile" name="mobile"
                                                               value="{{$supplier->mobile}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Fax:</label>
                                                        <input type="number" class="form-control" id="fax" name="fax"
                                                               value="{{$supplier->fax}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name"
                                                               class="col-form-label">Email:</label>
                                                        <input type="text" class="form-control" id="email" name="email"
                                                               value="{{$supplier->email}}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                                                class="fa fa-times"> Close</i></button>
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save">
                                                            Update</i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>

                        </table>
                        {!! $suppliers->render() !!}
                    @else
                        <div class="alert alert-warning col-lg-12 text-center" role="alert">
                            <span>{{ $message }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $('div.alert').delay(2000).slideUp(300);
    </script>
@endsection
