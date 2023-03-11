@extends('admin_template')


@section('content')
    <div class="container-fluid" style="margin-top:2%">
        <div class="row form-group">

            <div class="col-md-4">

                <div class="info-box">
                    <span class="info-box-icon bg-default elevation-1">
                        <a href="/user/list"><i class="fa fa-users"></i></a></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Users</span>
                        <span class="info-box-number"><?=$users?></span>

                    </div>
                </div>

            </div>
            <div class="col-md-4">

                <div class="info-box">
                    <span class="info-box-icon bg-default elevation-1">
                        <a href="/location/index"><i class="fa fa-map"></i></a></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Locations</span>
                        <span class="info-box-number"><?=$locations?></span>

                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="info-box">
                    <span class="info-box-icon bg-default elevation-1">
                        <a href="/supplier/index"><i class="fa fa-truck-moving"></i></a></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Suppliers</span>
                        <span class="info-box-number"><?=$suppliers?></span>

                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="info-box">
                    <span class="info-box-icon bg-default elevation-1">
                        <a href="/product/list"><i class="fa fa-cubes"></i></a></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Products</span>
                        <span class="info-box-number"><?=$products?></span>

                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="info-box">
                    <span class="info-box-icon bg-default elevation-1">
                        <a href="/issues/list"><i class="fa fa-arrow-alt-circle-right"></i></a></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Issues</span>
                        <span class="info-box-number"><?=$grns?></span>

                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="info-box">
                    <span class="info-box-icon bg-default elevation-1">
                        <a href="/invoice/list"><i class="fa fa-money-bill"></i></a></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Invoices</span>
                        <span class="info-box-number"><?=$invoices?></span>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
<style>


    .circle-tile {
        margin-bottom: 15px;
        text-align: center;
    }

    .circle-tile-heading {
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 100%;
        color: #FFFFFF;
        height: 80px;
        margin: 0 auto -40px;
        position: relative;
        transition: all 0.3s ease-in-out 0s;
        width: 80px;
    }

    .circle-tile-heading .fa {
        line-height: 80px;
    }

    .circle-tile-content {
        padding-top: 50px;
    }

    .circle-tile-number {
        font-size: 26px;
        font-weight: 700;
        line-height: 1;
        padding: 5px 0 15px;
    }

    .circle-tile-description {
        text-transform: uppercase;
    }

    .circle-tile-footer {
        background-color: rgba(0, 0, 0, 0.1);
        color: rgba(255, 255, 255, 0.5);
        display: block;
        padding: 5px;
        transition: all 0.3s ease-in-out 0s;
    }

    .circle-tile-footer:hover {
        background-color: rgba(0, 0, 0, 0.2);
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
    }

    .circle-tile-heading.dark-blue:hover {
        background-color: #2E4154;
    }

    .circle-tile-heading.green:hover {
        background-color: #138F77;
    }

    .circle-tile-heading.orange:hover {
        background-color: #DA8C10;
    }

    .circle-tile-heading.blue:hover {
        background-color: #2473A6;
    }

    .circle-tile-heading.red:hover {
        background-color: #CF4435;
    }

    .circle-tile-heading.purple:hover {
        background-color: #7F3D9B;
    }

    .tile-img {
        text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.9);
    }

    .dark-blue {
        background-color: #34495E;
    }

    .green {
        background-color: #16A085;
    }

    .blue {
        background-color: #2980B9;
    }

    .orange {
        background-color: #F39C12;
    }

    .red {
        background-color: #E74C3C;
    }

    .purple {
        background-color: #8E44AD;
    }

    .dark-gray {
        background-color: #7F8C8D;
    }

    .gray {
        background-color: #95A5A6;
    }

    .light-gray {
        background-color: #BDC3C7;
    }

    .yellow {
        background-color: #F1C40F;
    }

    .text-dark-blue {
        color: #34495E;
    }

    .text-green {
        color: #16A085;
    }

    .text-blue {
        color: #2980B9;
    }

    .text-orange {
        color: #F39C12;
    }

    .text-red {
        color: #E74C3C;
    }

    .text-purple {
        color: #8E44AD;
    }

    .text-faded {
        color: rgba(255, 255, 255, 0.7);
    }


</style>