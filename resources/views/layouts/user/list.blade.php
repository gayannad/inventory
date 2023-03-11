@extends('admin_template')
@section('content')
    <div class="container-fluid">
        <div class="card">

            <div class="card-body">
                <form action="/user/search" method="post">
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
                <div class="form-group">
                    @if(isset($users))
                        <table class="table table-bordered table-responsive-lg">
                            <thead class="">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            @foreach($users as $key=> $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->first_name .' '. $user->last_name}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>
                                        @if($user->status == ACTIVE)
                                            <span class="badge badge-pill badge-primary font-weight-bold">Active</span>
                                        @elseif($user->status == DEACTIVE)
                                            <span class="badge badge-pill badge-danger font-weight-bold">DeActive</span>
                                        @endif
                                    </td>
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
                                            <form action="/user/update" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label
                                                                class="col-form-label">FIRST NAME:</label>
                                                        <input type="text" class="form-control"
                                                               name="first_name"
                                                               id="name_{{$key}}" value="{{$user->first_name}}"
                                                               required>
                                                        <input type="hidden" value="{{$user->id}}" name="id">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">LAST NAME:</label>
                                                        <input type="text" class="form-control" id="last_name"
                                                               value="{{$user->last_name}}" required
                                                               name="last_name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="telephone"
                                                               class="col-form-label">TELEPHONE:</label>
                                                        <input type="number" class="form-control" id="telephone"
                                                               value="{{$user->telephone}}"
                                                               name="telephone">
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                                class="col-form-label">EMAIL:</label>
                                                        <input type="text" class="form-control" id="email"
                                                               value="{{$user->email}}" name="email">
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
                        </table>
                        {!! $users->render() !!}
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