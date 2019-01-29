@extends('spark::layouts.app')

@section('breadcrumb')
<div class="container">



    <div class="row">

        <div class="col-md-12">


            <div class="app-heading-container app-heading-bordered bottom">
                <ol class="breadcrumb">
                    <li><a href="/home">Home</a></li>
                    <li><a href="/home">Coupons</a></li>
                    <li class="active">Redemptions</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content')








<redeemed  :coupon_bank_id="{{$coupon_bank_id}}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-heading panel-heading-button">Redemptions </div>
                <div v-if="!couponCodes.length" class="alert alert-warning" role="alert"><strong>No Redemptions yet!</strong></div>

                <div v-else class="panel panel-default">

                    <div class="panel-body"> 

                        <div v-if="loaded"  class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>CODE</th>
                                        <th>IP ADDRESS</th>
                                        <th>DATE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(couponCode, index) in couponCodes">

                                        <td>@{{couponCode.code}}</td>
                                        <td>@{{couponCode.redeemed.ip}}</td>
                                        <td>@{{formatDate(couponCode.created_at.date)}}</td>
                                        

                                       
                                    </tr>

                                </tbody>
                            </table>
                            <pagination :current-page="currentPage"  :total-pages="totalPages" @on-paginate="onPaginate($event)"></pagination>

                        </div>
                        <div v-else class="loader"><img src="/img/loader.gif"></div>

                    </div>
                </div>
            </div>
        </div>



       
    </div>









</redeemed>
@endsection
