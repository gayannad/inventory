@extends('admin_template')
<meta name="csrf-token" content="{!! csrf_token() !!}">

@section('content')
    <div class="container-fluid" ng-app="productApp" ng-controller="productCtrl">
        <form action="/product/save" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">

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
                    <div class="row">
                        <div class="card col-lg-8">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Category</label>
                                    <div class="col-lg-7">
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
                                    <div class="col-lg-2">
                                        {{--<button type="button" class="btn btn-dark btn-sm" data-toggle="modal"--}}
                                                {{--data-target="#categoryModal" data-whatever="@mdo"><i--}}
                                                    {{--class="fa fa-plus-circle"></i>--}}
                                        {{--</button>--}}
                                        <button type="button" class="btn btn-dark btn-sm" data-toggle="modal"
                                                data-target="#categoryModal" data-whatever="@mdo"><i
                                                    class="fa fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Brand</label>
                                    <div class="col-lg-7">
                                        <select id="brand" name="brand"
                                                class="form-control{{$errors->has('brand') ? ' is-invalid' : ''}}"
                                                value="{{old('brand')}}" >
                                        </select>
                                        @if ($errors->has('brand'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('brand') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-dark btn-sm" data-toggle="modal"
                                                data-target="#brandModal" data-whatever="@mdo"><i
                                                    class="fa fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Supplier</label>
                                    <div class="col-lg-9">
                                        <select id="supplier" name="supplier"
                                                class="form-control{{$errors->has('supplier') ? ' is-invalid' : ''}}"
                                                value="{{old('location')}}" >
                                        </select>
                                        @if ($errors->has('supplier'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('supplier') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Description</label>
                                    <div class="col-lg-9">
                                        <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                               value="{{ old('description') }}" name="description" id="description" type="text"
                                               >
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('description') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Barcode</label>
                                    <div class="col-lg-9">
                                        <input class="form-control{{$errors->has('barcode') ? ' is-invalid' : ''}}"
                                               type="text"
                                               name="barcode" value="{{ old('barcode') }}" >
                                        @if ($errors->has('barcode'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('barcode') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-lg-3 col-form-label form-control-label">Tax</label>--}}
{{--                                    <div class="col-lg-9">--}}
{{--                                        <select id="tax" name="tax" class="form-control" value="{{old('location')}}"--}}
{{--                                                >--}}
{{--                                        </select>--}}
{{--                                        @if ($errors->has('tax'))--}}
{{--                                            <span class="invalid-feedback"><strong>{{ $errors->first('tax') }}</strong></span>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Cost Price</label>
                                    <div class="col-lg-9">
                                        <input class="form-control{{$errors->has('cost_price') ? ' is-invalid' : ''}}"
                                               type="text"
                                               name="cost_price" value="{{ old('cost_price') }}" >
                                        @if ($errors->has('cost_price'))
                                            <span class="invalid-feedback">
                                    <strong>
                                        {{ $errors->first('cost_price') }}
                                    </strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Selling Price</label>
                                    <div class="col-lg-9">
                                        <input class="form-control{{$errors->has('selling_price') ? ' is-invalid' : ''}}"
                                               type="text"
                                               name="selling_price" value="{{ old('selling_price') }}" >
                                        @if ($errors->has('selling_price'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('selling_price') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card col-lg-4">
                            <div class="card-body">
                                <div class="form-group" style="padding-top: 20px">
                                    <img id="product_image" class="img-thumbnail" width="200"
                                         src="{{ asset('images/no_image.jpg') }}"
                                         alt="product_image"/>
                                    <p>Choose image</p>
                                    <input type='file' name="image" id="itempic" onchange="imageUpload(this);"/>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row float-right" style="padding-top: 50px">
                        <input type="submit" class="btn btn-primary" value="Create Product">
                    </div>
                </div>
            </div>
        </form>

        <div class="modal fade" id="categoryModal" role="dialog" tabindex="-1" aria-labelledby="categoryModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="categoryForm">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title" id="exampleModalLabel">New Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="category" class="col-form-label">Discription</label>
                                <input type="text" class="form-control" id="category_name" name="category_name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="saveCategory()"
                                    id="cat">Save
                            </button>
                            <input type="hidden" name="_token" value="{{Session::token()}}">

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="brandModal" tabindex="-1" role="dialog" aria-labelledby="brandModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form>
                        <div class="modal-header bg-info">
                            <h5 class="modal-title" id="exampleModalLabel">New Brand</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="brand_name" class="col-form-label">Discription</label>
                                <input type="text" class="form-control" id="brand_name" name="brand_name">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="saveBrand()" data-dismiss="modal">
                                Save
                            </button>
                            <input type="hidden" name="_token" value="{{Session::token()}}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script>

        $('div.alert').delay(2000).slideUp(300);
        var app = angular.module('productApp', []);
        app.controller('productCtrl', function ($scope) {


        });


        function saveCategory() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var category_name = $('#category_name').val();
            console.log(category_name)
            $.ajax({
                url: '/product/category/save',
                method: 'post',
                data: {
                    category_name: category_name
                }

            }).done(function (response) {

                $('#category_name').val('');
                $('#category').html('');
                getCategories();

            });
        }

        function saveBrand() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var brand_name = $('#brand_name').val();
            $.ajax({
                url: '/product/brand/save',
                method: 'post',
                data: {
                    brand_name: brand_name
                }

            }).done(function (response) {
                console.log(response)
                $('#brand_name').val('');
                $('#brand').html('');
                getBrands();

            });
        }

        $(function () {
            getSuppliers();
            getCategories();
            getBrands();
            // getTaxProfiles();
        });

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
                        if (s >= 200000 || h > w) {
                            setTimeout(function () {
                                sweetAlert("Oops...", "Attachment should smaller than 200 kb and same width, height!", "error");
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

        function getSuppliers() {
            $.getJSON("/supplier/list", function (data) {

                $.each(data, function (key, val) {
                    $('#supplier').append("<option value='" + val.id + "'>" + val.comapany_name + "</option>");
                })
            });
        }

        function getCategories() {
            $.getJSON("/product/category/list", function (data) {
                $.each(data, function (key, val) {
                    $('#category').append("<option value='" + val.id + "'>" + val.category + "</option>");
                })
            })
        }

        function getBrands() {
            $.getJSON("/product/brand/list", function (data) {

                $.each(data, function (key, val) {
                    $('#brand').append("<option value='" + val.id + "'>" + val.brand + "</option>");
                })
            })
        }

        // function getTaxProfiles() {
        //     $.getJSON("/product/taxProfile", function (data) {
        //             console.log(data)
        //         $.each(data, function (key, val) {
        //             $('#tax').append("<option value='" + val.id + "'>" + val.value + "</option>");
        //         })
        //     })
        // }

    </script>

@endsection
