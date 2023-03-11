@extends('admin_template')

@section('content')
    <div class="container" ng-controller="returnCtrl" ng-app="returnApp">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
                <form action="{{ route('srn.save') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title text-info text-uppercase">
                                Return Note(RN)
                            </div>
                            <div class="float-right">
                                <a href="/return/return-list" target="_self">
                                    <button type="button" class="btn btn-success btn-sm float-right">
                                        <i class="fa fa-list">Return List</i>
                                    </button>
                                </a>
                                </button>
                            </div>
                        </div>
                        @if (session('alert'))
                            <div class="alert alert-success">
                                <button type="button"
                                        class="close"
                                        data-dismiss="alert"
                                        aria-hidden="true">
                                </button>
                                {{ session('alert') }}
                            </div>
                        @endif

                        <div class="card-body">
                            <div class="form-group card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="">Supplier</label>
                                            <select name="supplier" id="supplier" class="form-control"
                                                    ng-model="supplier"
                                                    ng-change="selectSupplier()" required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="">Search</label>
                                            <input type="search" id="keyword" class="form-control" ng-model="keyword"
                                                   ng-change="searchItem(supplier)">
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
                                                <tr ng-repeat="product in products">
                                                    <td>@{{ product['id'] }}</td>
                                                    <td>
                                                        <span>
                                                            <img ng-if="product.img_url != null"
                                                                 src="/uploads/@{{ product['img_url'] }}" alt=""
                                                                 width="20" class="img-rounded">
                                                            <img ng-if="product-img_url == null"
                                                                 src="{{asset('img/no_image.jpg')}}" alt="" width="20"
                                                                 class="img-rounded">
                                                        </span>
                                                        @{{ product['description'] }}
                                                    </td>
                                                    <td>@{{ product['cost_price'] | currency :'LKR ':2 }}</td>
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
                                            <table class="table table-striped table-responsive-lg small">
                                                <tr>
                                                    <th class="text-right">Item Code</th>
                                                    <th class="text-right">Description</th>
                                                    <th class="text-right">Cost Price</th>
                                                    <th class="text-right">Selling Price</th>
                                                    <th class="text-right">Stock Available</th>
                                                    <th class="text-right">Qty</th>
                                                    <th class="text-right">Total</th>
                                                    <th class="text-right">Action</th>
                                                    </th>
                                                <tr ng-repeat="x in item_cart">
                                                    <td class="text-right">@{{ x.id }}<input type="hidden" name="id[]"
                                                                                             value="@{{ x.id }}"
                                                                                             ng-model="x.id"></td>
                                                    <td class="text-right">
                                                        <span>
                                                            <img ng-if="x.img_url != null"
                                                                 src="/uploads/@{{ x['img_url'] }}" alt=""
                                                                 width="20" class="img-rounded">
                                                            <img ng-if="x.img_url == null"
                                                                 src="{{asset('img/no_image.jpg')}}" alt="" width="20"
                                                                 class="img-rounded">
                                                        </span>
                                                        @{{ x.description }}
                                                        <input type="hidden" name="description[]"
                                                               value="@{{ x.description }}">
                                                    </td>
                                                    <td class="text-right">@{{ x.cost_price |currency :'LKR ':2 }}<input
                                                                type="hidden" name="cost_price[]"
                                                                value="@{{ x.cost_price |currency :'LKR ':2 }}"></td>
                                                    <td class="text-right">@{{ x.sell_price |currency :'LKR ':2 }}<input
                                                                type="hidden" name="sell_price[]"
                                                                value="@{{ x.sell_price |currency :'LKR ':2 }}"></td>
                                                    <td class="text-right">@{{ x.stock }}</td>
                                                    <td class="text-right"><input type="number" name="qty[]"
                                                                                  ng-model="x.qty" min="1"
                                                                                  max="@{{ x.stock }}"></td>
                                                    <td class="text-right">@{{ x.cost_price * x.qty |currency:'LKR ':2
                                                        }}
                                                    </td>
                                                    <td class="text-right">
                                                        <button type="button" ng-click="itemRemove(index)">
                                                            <i class="text-danger">X</i>
                                                        </button>
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
                                        <div class="col-lg-8">
                                            <label for="">Remarks</label>
                                            <textarea name="remarks" id="remarks" cols="60" rows="4"
                                                      class="form-control"></textarea>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="pull-right">
                                                <label for="">Total Cost</label>
                                                <input type="text" class="form-control" name="total_cost" id="total_cost" readonly
                                                       value="@{{ getTotalCost() |currency:'LKR ':2 }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row float-right">
                                        <input type="submit" class="btn btn-primary" value="Create RN">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('div.alert').delay(2000).slideUp(300);

        var app = angular.module("returnApp", []);

        app.controller("returnCtrl", function ($scope, $http) {


            $scope.item_cart = [];

            $scope.searchItem = function (supplier) {
                var keyword = $('#keyword').val();
                $http({
                    url: '/return/product-list',
                    method: 'post',
                    data: {
                        keyword: keyword,
                        supplier: supplier,
                    }
                }).then(function (response) {
                    $scope.products = response.data;
                });
            };

            $scope.selectSupplier = function () {
                var supplier = $('#supplier').val();
                $scope.searchItem(supplier);
            };

            $scope.selectItem = function (x) {

                $scope.item_cart.push({
                    id: x.id,
                    description: x.description,
                    cost_price: x.cost_price,
                    sell_price: x.sell_price,
                    img_url: x.img_url,
                    stock: x.stock,
                    qty: 0,
                });
                $('#keyword').val('');
                $scope.products = [];

            };

            $scope.itemRemove = function (index) {
                $scope.item_cart.splice(index, 1);
            };

            $scope.getTotalCost = function () {
                var total_cost = 0;
                for (var i = 0; i < $scope.item_cart.length; i++) {
                    var product = $scope.item_cart[i];
                    total_cost += (product.cost_price * product.qty);
                }
                return total_cost;
            }
        });

        function getSuppliers() {
            $.getJSON("/supplier/list", function (data) {

                $.each(data, function (key, val) {
                    $('#supplier').append("<option value='" + val.id + "'>" + val.company_name + "</option>");
                })
            });
        }

        $(function () {
            getSuppliers();

        });
    </script>
@stop