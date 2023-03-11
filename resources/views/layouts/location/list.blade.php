<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 5/25/18
 * Time: 4:32 PM
 */
?>
@extends('admin_template')

@section('content')
    <div class="container-fluid">
        <div class="card">

            <div class="card-body">
                <form action="/location/search" method="post">
                    <div class="form-group row">
                        {{csrf_field()}}
                        <div class="col-lg-6">
                            <input type="text" name="search" class="form-control" placeholder="SEARCH">
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary btn-sm float-left"><i
                                        class="fa fa-search">Search</i></button>
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
                    @if(isset($locations))
                        <table class="table table-bordered">
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
                            @foreach($locations as $key=>  $location)
                                <tr>
                                    <td>{{$location->id}}</td>
                                    <td>{{$location->name}}</td>
                                    <td>{{$location->contact_person}}</td>
                                    <td>{{$location->telephone}}</td>
                                    <td>{{$location->email}}</td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal_{{$key}}"
                                                data-whatever="@mdo" id="view_{{$key}}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal_{{$key}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">

                                        <div class="modal-content">
                                            <form action="/location/update" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Location</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="recipient-name"
                                                               class="col-form-label">Name:</label>
                                                        <input type="text" class="form-control"
                                                               name="name"
                                                               id="name_{{$key}}" value="{{$location->name}}"
                                                               required>
                                                        <input type="hidden" value="{{$location->id}}" name="id">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Contact
                                                            person:</label>
                                                        <input type="text" class="form-control" id="contact_person"
                                                               value="{{$location->contact_person}}" required
                                                               name="contact_person">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="telephone"
                                                               class="col-form-label">Telephone:</label>
                                                        <input type="number" class="form-control" id="telephone"
                                                               value="{{$location->telephone}}" required
                                                               name="telephone">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address"
                                                               class="col-form-label">Address:</label>
                                                        <input type="text" class="form-control" id="address"
                                                               value="{{$location->address}}" required name="address">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="recipient-name"
                                                               class="col-form-label">Email:</label>
                                                        <input type="text" class="form-control" id="email"
                                                               value="{{$location->email}}" name="email">
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
                        {!! $locations->render() !!}
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
