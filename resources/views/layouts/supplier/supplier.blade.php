@extends('admin_template')

@section('content')
<div class="container" ng-controller="supplierCtrl" ng-app="supplierApp">
    <div class="card bg-light text-dark">
        @if (session('alert'))
        <div class="alert alert-success">
            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-hidden="true">&times;</button>
            {{ session('alert') }}
        </div>
        @endif
        <div class="card-body">
            <form class="form" role="form" autocomplete="off" action="/supplier/save" method="post">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Company name</label>
                    <div class="col-lg-9">
                        <input class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                               value="{{ old('name') }}" name="company_name" id="company_name" type="text" >
                        @if ($errors->has('company_name'))
                        <span class="invalid-feedback">
                           <strong>{{ $errors->first('company_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Contact person</label>
                    <div class="col-lg-9">
                        <input class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}"
                               value="{{ old('name') }}" name="contact_person" id="contact_person" type="text" >
                        @if ($errors->has('contact_person'))
                        <span class="invalid-feedback">
                           <strong>{{ $errors->first('contact_person') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Telephone</label>
                    <div class="col-lg-9">
                        <input class="form-control{{ $errors->has('telephone') ? ' is-invalid' : ''}}" type="text"
                               name="telephone" value="{{ old('telephone') }}" >
                        @if ($errors->has('telephone'))
                        <span class="invalid-feedback">
                           <strong>{{ $errors->first('telephone') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Fax</label>
                    <div class="col-lg-9">
                        <input class="form-control{{$errors->has('fax') ? ' is-invalid' : ''}}" type="text"
                               name="fax" value="{{ old('fax') }}">
                        @if ($errors->has('fax'))
                        <span class="invalid-feedback">
                           <strong>{{ $errors->first('fax') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Mobile</label>
                    <div class="col-lg-9">
                        <input class="form-control{{$errors->has('mobile') ? ' is-invalid' : ''}}" name="mobile"
                               id="mobile" value="{{ old('mobile') }}" type="text">
                        @if ($errors->has('mobile'))
                        <span class="invalid-feedback">
                           <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
                    <div class="col-lg-9">
                        <input class="form-control{{$errors->has('email') ? ' is-invalid' : ''}}" type="email" id="email"
                               name="email" value="{{old('email')}}">
                        @if ($errors->has('email'))
                        <span class="invalid-feedback">
                           <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Category</label>
                    <div class="col-lg-9">
                        <select id="category" name="category"
                                class="form-control{{$errors->has('category') ? ' is-invalid' : ''}}"
                                value="{{old('category')}}" >
                        </select>
                        @if ($errors->has('category'))
                            <span class="invalid-feedback">
                           <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="row float-right" style="padding-top: 50px">
                    <input type="submit" class="btn btn-primary" value="Create Supplier">

                </div>
            </form>
        </div>
    </div>

</div>
</div>
<script>
    $('div.alert').delay(2000).slideUp(300);

    var commentApp = angular.module('supplierApp', []);
    commentApp.controller('supplierCtrl',function () {
       console.log('test')
    });

    $(function () {
        getCategories();
    });

    function getCategories() {
        $.getJSON("/product/category/list", function (data) {
            $.each(data, function (key, val) {
                $('#category').append("<option value='" + val.id + "'>" + val.category + "</option>");
            })
        })
    }

</script>
@endsection
