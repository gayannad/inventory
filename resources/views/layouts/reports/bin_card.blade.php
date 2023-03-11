<?php
/**
 * Created by IntelliJ IDEA.
 * User: gayan
 * Date: 7/24/18
 * Time: 9:40 AM
 */ ?>
@extends('admin_template')
@section('content')
    <div class="container-fluid" ng-app="binApp" ng-controller="binCtrl">
        <div class="card">
            <div class="card-header small">
                <div class="card-title">Bin Card</div>
            </div>
            <div class="card-body">
                <div class="form-group card" id="header">
                    <div class="card-body">
                        <form action="" id="gtnform">
                            <div class="row">
                                <div class="col-lg-3 small">
                                    <input type="datetime" ui-date="dateOptions" class="form-control"
                                           placeholder="From"
                                           name="from" id="from" ng-model="from" required/>
                                </div>
                                <div class="col-lg-3 small">
                                    <input type="datetime" ui-date="dateOptions" class="form-control"
                                           placeholder="To"
                                           name="to" id="to" ng-model="to" required/>
                                </div>
                                <div class="col-lg-3 small">
                                    <input type="text" class="form-control" placeholder="product" name="product"
                                           id="product" ng-model="product" required/>
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary btn-sm" ng-click="submitForm()">Search
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" ng-click="print()">Print
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="card" id="card2">
                    <div class="card-body">
                        <table class="table table-responsive-sm table-bordered small">
                            <thead class="bg-navy">
                            <tr>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Document</th>
                                <th>Qty</th>
                            </tr>
                            </thead>
                            @foreach($bins as $bin)
                                <tr>
                                    <td>{{$bin->date}}</td>
                                    <td>{{$bin->reference}}</td>
                                    @if($bin->type == DOCUMENT_TYPE_GRN)
                                        <td><span>GRN</span></td>
                                    @elseif($bin->type == DOCUMENT_TYPE_GTN)
                                        <td><span>GTN</span></td>
                                    @else
                                        <td><span>RETURN</span></td>
                                    @endif
                                    <td>{{$bin->qty}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        var app = angular.module('binApp', ['ui.date']);

        app.controller('binCtrl', function ($scope, $http) {

            $scope.dateOptions = {
                changeYear: true,
                changeMonth: true,
                dateFormat: 'yy-mm-dd'
            };

            $scope.viewPo = function (id) {
                window.open('/grn/view/' + id, '_blank');
            }

            $scope.print = function () {
                window.print();
            }

            $scope.submitForm = function () {
                $('#gtnform').submit();
            }

        })


    </script>

    <style>
        @media print {

            #header {
                visibility: hidden;
            }

            #card2 {
                margin-top: -150px;
            }

            .main-footer {
                visibility: hidden;
            }
        }
    </style>
@endsection
