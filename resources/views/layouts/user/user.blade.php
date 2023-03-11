@extends('admin_template')

@section('content')
    <div class="container-fluid">
        <div class="card  bg-light text-dark ">

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

            <div class="card-body">

                <form class="form" role="form" autocomplete="off" action="/user/save" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="col-form-label form-control-label">First name</label>
                            <input class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                   value="{{ old('name') }}" name="first_name" id="first_name" type="text">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('first_name') }}</span>
                        </span>
                            @endif
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-form-label form-control-label">Last name</label>
                            <input class="form-control{{$errors->has('last_name') ? ' is-invalid' : ''}}" type="text"
                                   name="last_name" value="{{ old('last_name') }}">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('last_name') }}</span>
                        </span>
                            @endif
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-form-label form-control-label">Mobile</label>
                            <input class="form-control{{$errors->has('mobile') ? ' is-invalid' : ''}}" name="mobile"
                                   id="mobile" value="{{ old('mobile') }}" type="number">
                            @if ($errors->has('mobile'))
                                <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('mobile') }}</span>
                        </span>
                            @endif
                        </div>
                        <div class="form-group col-lg-6">
                            <label class=" col-form-label form-control-label">Email</label>
                            <input class="form-control{{$errors->has('email') ? ' is-invalid' : ''}}" type="email"
                                   id="email"
                                   name="email" value="{{old('email')}}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('email') }}</span>
                        </span>
                            @endif
                        </div>
                        <div class="form-group col-lg-6">
                            <label class=" col-form-label form-control-label">Location</label>
                            <select id="location" name="location" class="form-control" required>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-form-label form-control-label">Username</label>
                            <input class="form-control{{$errors->has('username') ? ' is-invalid' : ''}}" type="text"
                                   name="username" value="{{ old('username') }}">
                            @if ($errors->has('username'))
                                <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('username') }}</span>
                        </span>
                            @endif
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-form-label form-control-label">Password</label>
                            <input class="form-control{{$errors->has('password') ? ' is-invalid' : ''}}" name="password"
                                   type="password">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('password') }}</span>
                        </span>
                            @endif
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-form-label form-control-label">Confirm</label>
                            <input class="form-control" id="password-confirm" name="password_confirmation"
                                   type="password">
                        </div>
                        <div class="form-group col-lg-4" style="padding-top: 20px">
                            <img id="product_image" class="img-thumbnail" width="200"
                                 src="{{ asset('images/no_image.jpg') }}"
                                 alt="product_image"/>
                            <p>Choose image</p>
                            <input type='file' name="image" id="itempic" onchange="imageUpload(this);"/>
                        </div>
                    </div>
                    <div class="row float-right" style="padding-top: 50px">
                        <input type="submit" class="btn btn-primary" value="Create User">

                    </div>
                </form>
            </div>
        </div>

    </div>
    <script>
        $('div.alert').delay(2000).slideUp(300);

        function imageUpload(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = new Image();
                    img.src = e.target.result;

                    var w;
                    var h;
                    var s;
                    img.onload = function (ev) {
                        w = this.width;
                        h = this.height;
                        s = input.files[0].size;
                        if (s >= 100000 || h > w) {
                            setTimeout(function () {
                                sweetAlert("Oops...", "Attachment should smaller than 100 kb and same width, height!", "error");
                            }, 500);

                            this.value = "";
                            $('#itempic').val('')
                        } else {
                            $('#product_image')
                                .attr('src', e.target.result);
                        }
                    }

                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function getLocations() {
            $.getJSON("/user/locationlist", function (data) {

                $.each(data, function (key, val) {
                    $('#location').append("<option value='" + val.id + "'>" + val.name + "</option>");
                })
            });
        }

        $(function () {
            getLocations();

        });
    </script>
@endsection
