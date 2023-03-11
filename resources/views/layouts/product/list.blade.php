<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 6/4/18
 * Time: 11:11 AM
 */ ?>
@extends('admin_template')

@section('content')
    <div class="container-fluid">
        <div class="card">

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
                <form action="/product/search" method="post">
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
                <div class="form-group row">
                    @if(isset($products))
                        <table class="table table-bordered table-hover">
                            <thead class="">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Barcode</th>
                                <th>Cost price</th>
                                <th>Selling price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $key=>  $product)
                                <tr class="text-uppercase">
                                    <td>{{$product->id}}</td>
                                    @if($product->img_url != null)
                                        <td><img src="../uploads/products/{{$product->img_url}}" class="img-thumbnail"
                                                 width="45"></td>
                                    @elseif($product->img_url == null)
                                        <td><img src="../uploads/products/no_image.jpg" class="img-thumbnail"
                                                 width="45"></td>
                                    @endif
                                    <td>{{$product->description}}</td>
                                    <td>{{$product->barcode}}</td>
                                    <td>{{$product->cost_price}}</td>
                                    <td>{{$product->selling_price}}</td>
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
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <form action="/product/update" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="recipient-name"
                                                               class="col-form-label">Description:</label>
                                                        <input type="text" class="form-control"
                                                               name="description"
                                                               id="name_{{$key}}" value="{{$product->description}}">
                                                        <input type="hidden" name="id" value="{{$product->id}}">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="recipient-name"
                                                                   class="col-form-label">Barcode:</label>
                                                            <input type="text" class="form-control" id="barcode" name="barcode"
                                                                   value="{{$product->barcode}}">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="telephone"
                                                                   class="col-form-label">Category:</label>
                                                            <select name="category" id="category_{{$key}}"
                                                                    class="form-control">
                                                                @foreach($categories as $category)
                                                                    @if($category->id ==$product->category)
                                                                        <option selected
                                                                                value="{{$category->id}}">{{$category->category}}</option>
                                                                    @else
                                                                        <option value="{{$category->id}}">{{$category->category}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-lg-6">
                                                            <label for="telephone"
                                                                   class="col-form-label">Brand:</label>
                                                            <select name="brand" id="brand_{{$key}}"
                                                                    class="form-control">
                                                                @foreach($brands as $brand)
                                                                    @if($brand->id == $product->brand)
                                                                        <option selected
                                                                                value="{{$brand->id}}">{{$brand->brand}}</option>
                                                                    @else
                                                                        <option value="{{$brand->id}}">{{$brand->brand}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-lg-6">
                                                            <label for="telephone"
                                                                   class="col-form-label">Supplier:</label>
                                                            <select name="supplier" id="supplier" class="form-control">
                                                                @foreach($suppliers as $supplier)
                                                                    @if($supplier->id == $product->supplier)
                                                                        <option selected
                                                                                value="{{$supplier->id}}">{{$supplier->comapany_name}}</option>
                                                                    @else
                                                                        <option value="{{$supplier->id}}">{{$supplier->comapany_name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group col-lg-6">
                                                            <label for="telephone"
                                                                   class="col-form-label">Cost price:</label>
                                                            <input type="text" class="form-control" id="cost_price"
                                                                   value="{{$product->cost_price}}" name="cost_price">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="telephone" class="col-form-label">Selling
                                                                price:</label>
                                                            <input type="text" class="form-control" id="selling_price" name="selling_price"
                                                                   value="{{$product->selling_price}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group float-right" style="padding-top: 20px">
                                                        @if($product->img_url !=null)
                                                            <img id="product_image_{{$key}}" class="img-thumbnail" width="200"
                                                                 src="../uploads/products/{{$product->img_url}}"
                                                                 alt="product_image"/>
                                                        @elseif($product->img_url ==null)
                                                            <img id="product_image_{{$key}}" class="img-thumbnail" width="200"
                                                                 src="{{ asset('images/no_image.jpg') }}"
                                                                 alt="product_image"/>
                                                        @endif
                                                        <p>Choose image</p>
                                                            <input type='file' name="image" id="itempic_{{$key}}" onchange="imageUpload(this,'{{$key}}')"/>
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
                        {!! $products->render() !!}
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

        function imageUpload(input,index) {

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
                            $('#product_image_'+index)
                                .attr('src', e.target.result);
                        }
                    }

                };

                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
    <style>
        label {
            font-weight: bolder;
        }
    </style>
@endsection
