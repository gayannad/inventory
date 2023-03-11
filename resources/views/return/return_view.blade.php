@extends('layouts.admin')

@section('content')
    <div class="container" ng-controller="returnCtrl" ng-app="returnApp">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card" id="main">
                    <div class="card-header">
                        @if ($srns->status == \App\ReturnHeader::RETURN_APPROVED || $srns->status == \App\ReturnHeader::RETURN_REJECTED)
                            <button type="button" class="btn btn-primary btn-sm float-right" id="print" ng-click="print()">
                                <i class="fa fa-print">Print</i>
                            </button>
                        @endif
                        <div class="card-title float-left font-weight-bold">RETURN NOTE</div>
                    </div>
                </div>
                <div class="card-body">
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
                    <div class="card">
                        <div class="card-header">
                            <div class="row small">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <img src="{{ asset('img/logo_company.png') }}" alt="" class="small"
                                             width="90">
                                        <label for="" class="float-right"><b>GRN:</b>{{ $srns->id }}</label>
                                    </div>
                                    <div class="form-group">
                                        <span class="medium"><b>Vijitha Hardware,Urala,Wanduramba, info.vijithahardware@gmail.com</b></span>
                                        <label for="" class="float-right"><b>DATE:</b>{{ $srns->created_at }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body form-group">
                            <div class="row small">
                                <div class="col-sm-12 form-group">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="" class="font-weight-bold float-left">SUPPLIER :</label>
                                                <span>{{ $srns->suppliers->company_name }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="font-weight-bold float-left">ADDRESS :</label>
                                                <span>{{ $srns->suppliers->address }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="font-weight-bold float-left">CONTACT PERSON
                                                    :</label>
                                                <span>{{ $srns->suppliers->contact_person }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="font-weight-bold float-left">TELEPHONE
                                                    :</label>
                                                <span>{{ $srns->suppliers->telephone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card form-group">
                                <div class="card-body small">
                                    <table class="table table-bordered table-responsive-sm">
                                        <tr class="bg-light">
                                            <th>ITEM CODE</th>
                                            <th>ITEM NAME</th>
                                            <th>UNIT CP</th>
                                            <th>QTY</th>
                                            <th>TOTAL CP</th>
                                        </tr>
                                        <?php
                                        $total_cost = 0;
                                        ?>
                                        @foreach ($srns->details as $srn)
                                            @foreach ($srn->products as $product)
                                                <?php
                                                $cost = $product->cost_price * $srn->qty;
                                                $total_cost +=$cost;
                                                ?>
                                                <tr>
                                                    <td>{{ $product->id }}</td>
                                                    <td>{{ $product->description }}</td>
                                                    <td>LKR: {{ number_format($product->cost_price,2) }}</td>
                                                    <td>{{ $srn->qty }}</td>
                                                    <td>LKR: {{ number_format($cost,2) }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            @if ($srns->status == \App\ReturnHeader::RETURN_APPROVED)
                                <img src="{{ asset('img/approved.jpg') }}" alt="" class="small float-left"
                                     width="250">
                            @endif
                            @if ($srns->status === \App\ReturnHeader::RETURN_REJECTED)
                                <img src="{{ asset('img/rejected.png') }}" alt="" class="small float-left"
                                     width="250">
                            @endif
                            <div class="form-group float-right">
                                <label for="" class="col-form-label">Remarks</label>
                                <textarea name="" id="" cols="60" rows="3" class="form-control float-right" readonly>{{ $srns->remarks }}</textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if ($srns->status == \App\ReturnHeader::RETURN_PENDING)
                                <input type="submit" class="btn btn-primary float-right" value="Approve"
                                       ng-click="approveSrn({{ $srns->id }})">
                                <input type="button" class="btn btn-danger float-right mr-2" value="Reject"
                                       ng-click="rejectSrn({{ $srns->id }})">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('div.alert').delay(2000).slideUp(300);

        var app = angular.module('returnApp', []);

        app.controller('returnCtrl', function ($scope) {
            $scope.print = function () {
                window.print();
            };


            $scope.approveSrn = function (srn) {
                bootbox.dialog({
                    message: "Do ypu want to approve this Return Note?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-primary',
                            callback: function () {
                                window.open('/return/srn-approve/' + srn, '_self');
                            }
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger',
                        }
                    }
                });
            };

            $scope.rejectSrn = function (srn) {
                bootbox.dialog({
                    message: "Do you want to reject this Return Note?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-primary',
                            callback: function () {
                                window.open('/return/srn-reject/' + srn, '_self')
                            }
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger',
                        }
                    }
                });
            };
        });
    </script>
    <style>
        @media print {

            #print {
                visibility: hidden;
            }

            .main-footer {
                visibility: hidden;
            }
        }
    </style>
@stop