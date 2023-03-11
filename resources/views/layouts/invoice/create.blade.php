<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/16/18
 * Time: 5:30 PM
 */ ?>
@extends('admin_template')
@section('content')

    <div class="container-fluid" ng-app="invApp" ng-controller="invCtrl">
        <div class="card">
            <form action="/invoice/save" method="post">
                @csrf

                <div class="card-body">
                    @if (session('alert') =='Invoice Successfully Created !')
                        <div class="alert alert-success">
                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-hidden="true">&times;
                            </button>
                            {{ session('alert') }}
                        </div>
                    @endif
                    @if (session('alert') =='Error Creating Invoice !')
                        <div class="alert alert-danger">
                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-hidden="true">&times;
                            </button>
                            {{ session('alert') }}
                        </div>
                    @endif
                    <div class="card small">
                        <div class="card-header">
                            <div class="card-title font-weight-bold">Customer Details</div>
                        </div>

                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label form-control-label">Customer Name</label>
                                <div class="col-lg-10">
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           value="{{ old('name') }}" name="name" id="name" type="text">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
{{--                                <label class="col-lg-2 col-form-label form-control-label">NIC</label>--}}
{{--                                <div class="col-lg-4">--}}
{{--                                    <input class="form-control{{ $errors->has('nic') ? ' is-invalid' : '' }}"--}}
{{--                                           value="{{ old('nic') }}" name="nic" id="nic" type="text"--}}
{{--                                    >--}}
{{--                                    @if ($errors->has('nic'))--}}
{{--                                        <span class="invalid-feedback"><strong>{{ $errors->first('nic') }}</strong></span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label form-control-label">Mobile</label>
                                <div class="col-lg-4">
                                    <input class="form-control{{$errors->has('mobile') ? ' is-invalid' : ''}}"
                                           type="number"
                                           name="mobile" value="{{ old('mobile') }}">
                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('mobile') }}</strong></span>
                                    @endif
                                </div>
                                <label class="col-lg-2 col-form-label form-control-label">Telephone</label>
                                <div class="col-lg-4">
                                    <input class="form-control{{$errors->has('telephone') ? ' is-invalid' : ''}}"
                                           type="text"
                                           name="telephone" value="{{ old('telephone') }}">
                                    @if ($errors->has('telephone'))
                                        <span class="invalid-feedback">
                                    <strong>
                                        {{ $errors->first('telephone') }}
                                    </strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label form-control-label">Address</label>
                                <div class="col-lg-8">
                                    <textarea name="address" id="address"
                                              class="form-control{{$errors->has('address') ? ' is-invalid' : ''}}"></textarea>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('address') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="form-group card">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="">Search</label>
                                    <input type="search" class="form-control" id="keyword"
                                           ng-model="keyword" ng-change="searchItem()">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <table class="table table-striped small table-responsive-lg">
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>

                                        <tr class="small" ng-repeat="product in products">
                                            <td>@{{product['id']}}</td>
                                            <td>
                                            <span>
                                                <img ng-if="product.img_url !=null"
                                                     src="../uploads/products/@{{product['img_url']}}" alt=""
                                                     width="20" class="img-rounded">
                                                <img ng-if="product.img_url ==null" class="img-rounded"
                                                     src="{{ asset('images/no_image.jpg') }}" alt="" width="20">
                                            </span>
                                                @{{product['description']}}
                                            </td>
                                            <td>@{{product['selling_price'] | currency:'LKR ':2}}</td>
                                            <td>
                                                <button ng-click="selectItem(product)"><i
                                                            class="fa fa-check text-primary"></i></button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-responsive-lg table-bordered small">
                                        <tr>
                                            <th class="text-right">Item Code</th>
                                            <th>Description</th>
                                            <th class="text-right">Price</th>
                                            <th class="text-right">Stock Available</th>
                                            <th class="text-right">Qty</th>
                                            <th class="text-right">Total</th>
                                            <th class="text-right">Action</th>
                                        </tr>

                                        <tr ng-repeat="x in item_cart">
                                            <td class="text-right">@{{x.id}}<input type="hidden" name="id[]"
                                                                                   value="@{{ x.id }}" ng-model="x.id">
                                            </td>
                                            <td>
                                            <span>
                                                <img ng-if="x.img_url !=null"
                                                     src="../uploads/products/@{{x['img_url']}}" alt=""
                                                     width="30" class="img-rounded img-thumbnail">
                                                <img ng-if="x.img_url ==null" class="img-rounded img-thumbnail"
                                                     src="{{ asset('images/no_image.jpg') }}" alt="" width="30">
                                            </span>
                                                @{{ x.description }}
                                                <input type="hidden" name="description[]" value="@{{ x.description }}">
                                            </td>
                                            <td class="text-right">@{{ x.selling_price |currency:'LKR ':2}}<input
                                                        type="hidden" name="selling_price[]"
                                                        value="@{{ x.selling_price |currency:'LKR ':2}}"></td>
                                            <td class="text-right">@{{ x.stock }}</td>
                                            <td class="text-right"><input type="number" name="qty[]" ng-model="x.qty"
                                                                          class="text-right form-control" min="1"
                                                                          max="@{{ x.stock }}"></td>
                                            <td class="text-right">@{{ x.selling_price * x.qty |currency:'LKR ':2 }}
                                            </td>
                                            <td class="text-right">
                                                <button type="button" ng-click="itemRemove($index)">
                                                    <i class="text-danger">3</i></button>
                                            </td>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="item_in_cart" value="@{{ item_cart }}">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group card">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="">Remarks</label>
                                    <textarea name="remark" id="$remark" cols="40" rows="4"
                                              class="form-control"></textarea>
                                </div>
                                <div class="col-lg-6">
                                    <div class="pull-right">
                                        <label for="">Total Amount:</label>
                                        <input type="text" class="form-control" readonly
                                               value="@{{ getTotalCost() | currency:'LKR ':2}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row float-right ">
                                <input type="submit" value="Create Invoice" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $('div.alert').delay(2000).slideUp(300);
        var app = angular.module('invApp', []);
        app.controller('invCtrl', function ($scope, $http) {

            $scope.item_cart = [];

            $scope.searchItem = function () {
                var keyword = $('#keyword').val();
                $http({
                    url: '/invoice/productlist',
                    method: 'post',
                    data: {
                        keyword: keyword
                    }
                }).then(function (response) {
                    $scope.products = response.data;
                });
            }

            $scope.selectItem = function (x) {

                $scope.item_cart.push({
                    id: x.id,
                    description: x.description,
                    selling_price: x.selling_price,
                    img_url: x.img_url,
                    stock: x.stock,
                    qty: 0,
                });
                $('#keyword').val('');
                $scope.products = [];

            }

            $scope.itemRemove = function (index) {
                $scope.item_cart.splice(index, 1);
            }

            $scope.getTotalCost = function () {
                var total = 0;
                for (var i = 0; i < $scope.item_cart.length; i++) {
                    var product = $scope.item_cart[i];
                    total += (product.selling_price * product.qty);
                }
                return total;
            }
        })
    </script>
@endsection
