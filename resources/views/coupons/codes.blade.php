@extends('spark::layouts.app')
@section('content')
<codes  :coupon_bank_id="{{$coupon_bank_id}}" inline-template>
    <div class="container coupon-codes">
        <div class="row">
            <div class="col-md-12">
                <div class="app-heading-container app-heading-bordered bottom">
                    <ol class="breadcrumb">
                        <li><a href="/home">Home</a></li>
                        <li><a href="/funnel/{{$funnelId}}">{{$funnelName}}</a></li>
                        <li class="active">{{$bankName}}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="header-box">
            <div class="row">
                <div class="col-sm-8">
                    <h1 class="header-title">@{{bank.name}}</h1>
                    <p v-if="bank.description" class="info-text"><i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i> @{{bank.description}}</p>
                </div> 
                <div class="col-sm-4 pull-right">
                    <a :href="'/coupon-codes/export/'+this.coupon_bank_id" target="_blank" class="btn btn-primary pull-right" :class="{linkdisabled:!exportRedemptions}" >Export</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-heading panel-heading-button">
                    <div class="row">
                        
                        <div class="col-xs-3 col-md-2">
                            <select class="form-control numItemsDisplay" v-model="filterCode" @change="getCouponCodes(true)">
                                <option value="all" selected="">All</option>
                                <option value="redeemed">Redeemed</option>
                                <option value="noRedeemed">No Redeemed</option>
                              

                            </select>
                        </div>
                        <div class="col-md-6 pull-right">


                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#CCModal" @click="resetModal()">New Coupon Code</button>
                        </div>
                    </div>
                </div>
                <div v-if="!itemsCount" class="alert alert-warning" role="alert"><strong>You don't have any Coupon Banks yet!</strong><br/>Select <strong>New Coupon bank</strong> above to get started.</div>
                
                <div v-else-if="!results" class="panel panel-default">
                    <div class="panel-body no-results"> 
                        
                    </div>
                    
                </div>

                <div v-else class="panel panel-default">

                    <div class="panel-body"> 

                        <div  v-if="loaded" class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Actions</th>
                                        <th>Redemption</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(couponCode, index) in couponCodes">

                                        <td>@{{couponCode.code}}</td>


                                        <td>
                                            
                                            <button type="button" class="btn btn-success btn-xs" @click="editCode(couponCode, index)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</button>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteCode" @click="idToDelete=couponCode.id, indexToDelete=index"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button> 


                                        </td>
                                        <td><button v-if="couponCode.redeemed" type="button" class="btn btn-info btn-xs" @click="viewRedemption(couponCode.redeemed)"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Redemption</button></td>

                                    </tr>

                                </tbody>
                            </table>
                            

                        </div>
                        <div v-else class="loader"><img src="/img/loader.gif"></div>
                        <pagination v-if="loaded" :current-page="currentPage" :total-pages="totalPages" :total-items="totalItems" @on-paginate="onPaginate($event)" :num-items-display="numItemsDisplay" @itemdisplay="onItemDisplay($event)"></pagination>

                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="redemption-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Redemption Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body redemption-details">
                        <p v-for="(val,key) in redemptionDetails"><strong>@{{key}}</strong>: <span>@{{val}}</span></p>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to remove this code?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="confirmDelete(idToDelete, indexToDelete)">Confirm Delete</button>
                    </div>
                </div>
            </div>
        </div>




        <div class="modal fade" id="CCModal" tabindex="-1" role="dialog" aria-labelledby="CCModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CCModalLabel">@{{formData.editing?'Edit':'Add'}} Coupon Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="post" >


                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Code</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" v-model="formData.code" :placeholder="formData.editing?'@example: aaa111':'@example: aaa111,bbb66yy'">


                                </div>
                            </div>



                        </form>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click.prevent="formData.editing ? updateCouponCode() : createCouponCode()" :disabled="formData.busy">@{{formData.editing ? 'Update' : 'Create'}}</button>
                    </div>



                </div>

            </div>
        </div>
    </div>









</codes>
@endsection
