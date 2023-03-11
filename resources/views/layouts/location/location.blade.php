@extends('admin_template')

@section('content')
<div class="container">
    <div class="card bg-light text-dark">
        @if (session('alert'))
        <div class="alert  alert-success">
            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-hidden="true">&times;</button>
            {{ session('alert') }}
        </div>
        @endif
        <div class="card-body">
            <form class="form" role="form" autocomplete="off" action="/location/save" method="post">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Location name</label>
                    <div class="col-lg-9">
                        <input class="form-control{{ $errors->has('location_name') ? ' is-invalid' : '' }}"
                               value="{{ old('location_name') }}" name="location_name" id="location_name" type="text" >
                        @if ($errors->has('location_name'))
                        <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('location_name') }}</span>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Contact Person</label>
                    <div class="col-lg-9">
                        <input class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}"
                               value="{{ old('contact_person') }}" name="contact_person" id="contact_person"  type="text" >
                        @if ($errors->has('contact_person'))
                            <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('contact_person') }}</span>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Address</label>
                    <div class="col-lg-9">
                        <input class="form-control{{$errors->has('address') ? ' is-invalid' : ''}}" type="text"
                               name="address" value="{{ old('address') }}" >
                        @if ($errors->has('address'))
                        <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('address') }}</span>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Telephone</label>
                    <div class="col-lg-9">
                        <input class="form-control{{$errors->has('telephone') ? ' is-invalid' : ''}}" name="telephone"
                               id="mobile" value="{{ old('telephone') }}" type="text" >
                        @if ($errors->has('telephone'))
                        <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('telephone') }}</span>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
                    <div class="col-lg-9">
                        <input class="form-control{{$errors->has('email') ? ' is-invalid' : ''}}" type="email" id="email"
                               name="email" value="{{old('email')}}" >
                        @if ($errors->has('email'))
                        <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('email') }}</span>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Type</label>
                    <div class="col-lg-9">
                        <select id="type" name="type"
                                class="form-control{{$errors->has('type') ? ' is-invalid' : ''}}"
                                value="{{old('type')}}" >
                            <option value="0">Location Type</option>
                            <option value="2">Branch</option>
                            <option value="3">Hardware</option>
                            <option value="4">Electric Shop</option>
                        </select>
                        @if ($errors->has('type'))
                        <span class="invalid-feedback">
                           <span class="badge badge-danger">{{ $errors->first('type') }}</span>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="row pull-right float-right  " style="padding-top: 50px">
                    <input type="submit" class="btn btn-primary btn-md " value="Create Location">
                    <input type="hidden" name="_token" value="{{Session::token()}}">
                </div>
            </form>
        </div>
    </div>

</div>
<script>
    $('div.alert').delay(2000).slideUp(300);

</script>
@endsection
