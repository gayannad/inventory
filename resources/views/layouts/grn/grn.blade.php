<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 6/21/18
 * Time: 12:36 PM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container-fluid" ng-controller="grnCtrl" ng-app="grnApp">

        <div class="card">
            <div class="card-header">
{{--                <div class="card-title text-info text-uppercase">Good Receive Note(GRN)--}}
{{--                    <a href="/grn/list" target="_self">--}}
{{--                        <button type="button" class="btn btn-success btn-sm float-right "><i class="fa fa-list"> Grn--}}
{{--                                List</i>--}}
{{--                        </button>--}}
{{--                    </a></div>--}}

                <div class="col-xs-4">
                    <label for="type_gtn" class="control-label">Direct Purchase</label>
                    <input type="radio" class="radio-inline" id="type_gtn" ng-model="grn_type" value="1"
                           name="grn_type" ng-init="grn_type =1"/>
                    <label for="type_gtn" class="control-label">Goods Transfer Note</label>
                    <input type="radio" class="radio-inline" id="type_gtn" ng-model="grn_type" value="2"
                           name="grn_type"/>
                </div>


            </div>
            <form action="/stock/save" method="post">
                @csrf
                <div class="card-body" ng-show="grn_type ==1">
                    @if (session('alert') =='Grn Successfully Created !')
                        <div class="alert alert-success">
                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-hidden="true">&times;
                            </button>
                            {{ session('alert') }}
                        </div>
                    @elseif (session('alert') =='Error!')
                        <div class="alert alert-danger">
                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-hidden="true">&times;
                            </button>
                            {{ session('alert') }}
                        </div>
                    @endif


                    <div class="form-group card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <label for="">Supplier</label>
                                    <select id="supplier" name="supplier" class="form-control" required>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="">Invoice</label>
                                    <input type="text" class="form-control" placeholder="Invoice" name="invoice"
                                           id="invoice" required/>
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
                                    <table class="table table-striped  table-responsive-lg">
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>

                                        <tr class="" ng-repeat="product in products">
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
                                            <td>@{{product['cost_price'] | currency:'LKR ':2}}</td>
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
                                    <table class="table table-responsive-lg table-bordered">
                                        <tr>
                                            <th class="text-right">Item Code</th>
                                            <th>Description</th>
                                            <th class="text-right">Cost Price</th>
                                            <th class="text-right">Selling Price</th>
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
                                            <td class="text-right">
                                                @{{ x.cost_price |currency:'LKR ':2}}
                                                <input type="hidden" name="cost_price[]"
                                                       value="@{{ x.cost_price |currency:'LKR ':2}}">
                                            </td>
                                            <td class="text-right">
                                                @{{ x.selling_price |currency:'LKR ':2}}
                                                <input type="hidden" name="selling_price[]"
                                                       value="@{{ x.selling_price |currency:'LKR ':2}}">
                                            </td>
                                            <td class="text-right"><input type="number" name="qty[]" ng-model="x.qty"
                                                                          class="text-right" min="1"></td>
                                            <td class="text-right">@{{ x.cost_price * x.qty |currency:'LKR ':2 }}</td>
                                            <td class="text-right">
                                                <button type="button" ng-click="itemRemove($index)">
                                                    <i class="text-danger">X</i></button>
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
                                        <label for="">Total Cost:</label>
                                        <input type="text" class="form-control" readonly
                                               value="@{{ getTotalCost() | currency:'LKR ':2}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row float-right ">
                                <input type="submit" value="Create Grn" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body" ng-show="grn_type==2">
                <form action="/stock/accept" method="post">
                    @csrf
                    <div class="form-group card">
                        <div class="card-header">
                            <div class="card-title">Good Transfer Note</div>
                        </div>
                        <div class="form-group card-body">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="">Location From</label>
                                    <input type="text" class="form-control" ng-model="location_from_name" readonly>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">GTN</label>
                                    <select class="form-control" ng-model="gtn_no"
                                            ng-options="x.gtn_no as x.gtn_no for x in gtns"
                                            ng-change="selectGtn(gtn_no)">
                                    </select>
                                    <input type="hidden" name="gtn_no" id="gtn_no" value="@{{ gtn_no }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Product Code</th>
                                        <th>Description</th>
                                        <th>Unit Cost</th>
                                        <th>Unit Selling</th>
                                        <th>Qty</th>
                                    </tr>
                                    <tr ng-repeat="x in item_cart">
                                        <td>@{{x.product}}</td>
                                        <td>@{{x.description}}</td>
                                        <td>@{{x.cost_price}}</td>
                                        <td>@{{x.selling_price}}</td>
                                        <td>@{{x.qty}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default pull-right"><i
                                            class="fa fa-check text-success"></i> Accept
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        $('div.alert').delay(2000).slideUp(300);
        var app = angular.module("grnApp", []);

        app.controller("grnCtrl", function ($scope, $http, $window) {


            $window.onload = function () {
                $scope.loadGtns();
            };


            $scope.item_cart = [];

            $scope.searchItem = function () {
                var keyword = $('#keyword').val();

                $http({
                    url: '/stock/productlist',
                    method: 'post',
                    data: {
                        keyword: keyword
                    }
                }).then(function (response) {
                    $scope.products = response.data;
                });
            }

            $scope.selectItem = function (x) {
                var p = $scope.item_cart;

                $scope.item_cart.push({
                    id: x.id,
                    description: x.description,
                    cost_price: x.cost_price,
                    selling_price: x.selling_price,
                    img_url: x.img_url,
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
                    total += (product.cost_price * product.qty);
                }
                return total;
            }

            $scope.loadGtns = function () {
                $http({
                    url: '/stock/gtns'
                }).then(function (response) {
                    $scope.gtns = response.data;
                })
            }
            $scope.selectGtn = function (gtn_no) {
                $scope.gtn_no = gtn_no;
                $.each($scope.gtns, function (index, gtn) {
                    if (gtn.gtn_no == gtn_no) {
                        $scope.item_cart = gtn.details;
                        $scope.location_from_name = gtn.location;
                        $scope.location_from_id = gtn.location_from_id;
                        return;
                    }
                })
            }


        });

        function getSuppliers() {
            $.getJSON("/supplier/list", function (data) {
                $.each(data, function (key, val) {
                    $('#supplier').append("<option value='" + val.id + "'>" + val.comapany_name + "</option>");
                })
            });
        }

        $(function () {
            getSuppliers();

        });

    </script>
@endsection
