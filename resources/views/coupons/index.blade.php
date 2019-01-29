@extends('spark::layouts.app')
@section('content')
<coupons  :funnel_id="{{$data['id']}}" inline-template>

    <div class="container">

        <div class="row">

            <div class="col-md-12">


                <div class="app-heading-container app-heading-bordered bottom">
                    <ol class="breadcrumb">
                        <li><a href="/home">Home</a></li>

                        <li class="active">@{{headerData.name}}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="header-box">
            <div class="row">

                <div class="col-sm-6">
                    <h1 class="header-title">@{{headerData.name}}
                        <span class="small" ><i class="fa fa-calendar" aria-hidden="true"></i>  @{{formatDate(headerData.starts_at,'short')}} To @{{formatDate(headerData.ends_at,'short')}}</span>

                    </h1>
                    <p v-if="headerData.description" class="info-text"><i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i> @{{headerData.description}}</p>
                    <p v-if="headerData.tags.length" class="info-tex addedTags"><i class="glyphicon glyphicon-tags" aria-hidden="true"></i> <span style="margin-left: 8px;" v-for="tag in headerData.tags" :style="{color: tag.color}">@{{tag.name}}</span></p>

                </div>
                <div class="col-sm-6 text-right action-buttons">



                    <a href="#" data-toggle="modal" data-target="#funnelModal" @click="setFunnel(funnel_id)" class="btn btn-success">Edit Funnel</a>



                </div>


            </div>


        </div>




        <div class="row">

            <div class="col-md-12">
                <div class="panel-heading panel-heading-button">

                    <div class="row">

                        <div class="col-md-6 pull-right">


                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#CBModal" @click="resetModal()">New Coupon Bank</button>
                        </div>
                    </div>

                </div>
                <div v-if="!couponBanks.length" class="alert alert-warning" role="alert"><strong>You don't have any Coupon Banks yet!</strong><br/>Select <strong>New Coupon bank</strong> above to get started.</div>

                <div v-else class="panel panel-default">

                    <div class="panel-body"> 

                        <div  v-if="loaded" class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th>Name</th>


                                        <th style="min-width: 150px;">Type</th>
                                        <th style="min-width: 150px;">Number of Coupons</th>
                                        <th style="min-width: 150px;">Number of Redemptions</th>

                                        <th style="min-width: 565px;">Actions</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(couponBank, index) in couponBanks">

                                        <td>@{{couponBank.name}}</td>

                                        <td>@{{couponBank.type}}</td>
                                        
                                        <td>@{{couponBank.no_of_coupons}}</td>
                                        <td>@{{couponBank.no_of_redeemed}}</td>


                                        <td>
                                            <button type="button" class="btn btn-success btn-xs" @click="editCB(couponBank, index)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</button>

                                            <button type="button" class="btn btn-info btn-xs" @click="couponCodes(couponBank.id)"><span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> Codes</button>  
                                            <button type="button" class="btn btn-secondary btn-xs" @click="couponFields(couponBank.id)" ><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Validations</button>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteCoupon" @click="idToDelete=couponBank.id, indexToDelete=index"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button> 
                                            <button type="button" data-toggle="modal" data-target="#widget-source" @click.prevent="couponRedeemed(couponBank.id)" class="btn btn-primary btn-xs">Copy Widget Source</button> 
                                            <button type="button" data-toggle="modal" data-target="#widget-preview" class="btn btn-info btn-xs"> Preview</button> 
                                        </td>

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

        <div class="modal fade" id="widget-source" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Widget Source</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>@{{redemptionUrl}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="widget-preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Widget Preview</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="/img/preview.png" style="
                             width: 80%;
                             margin:  auto;
                             display: block;
                             ">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="funnelModal" tabindex="-1" role="dialog" aria-labelledby="funnelModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="funnelModalLabel">Edit Funnel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="post" >


                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" v-model="funnelData.name">


                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Description</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" style="resize:none;" rows="5" name="description" v-model="funnelData.description"></textarea>
                                    <span class="help-block">500 characters max.</span>

                                </div>
                            </div>

                            <!-- date start -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Available From</label>
                                <div class="col-md-6">

                                    <date-picker v-model="funnelData.starts_at" type="datetime" format="YYYY-MM-DD HH:mm:ss" lang="en"></date-picker>


                                </div>
                            </div>

                            <!-- Date end -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Available To</label>
                                <div class="col-md-6">

                                    <date-picker v-model="funnelData.ends_at" type="datetime" format="yyyy-MM-dd HH:mm:ss" lang="en"></date-picker>



                                </div>
                            </div>


                            <!-- Date end -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Tags</label>
                                <div class="col-md-6">
                                    <autocomplete anchor="name" label="" v-model="funnelData.preTag" :classes="{ input: 'form-control', list: 'data-list', item: 'data-list-item' }" :url="siteDomain+'/api/tags'" :on-select="onSelectTag">
                                </autocomplete>

                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Added tags</label>
                            <div v-if="funnelData.addedTags" class="col-md-6 addedTags">
                                <a v-for="(addedTag, index) in funnelData.addedTags" href="#" @click.prevent="removeTag(index)" :style="{color: addedTag.color}"><span class="glyphicon glyphicon-trash"></span> @{{addedTag.name}}</a>

                            </div>
                        </div>



                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click.prevent="updateFunnel()" :disabled="funnelData.busy">Update</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="CBModal" tabindex="-1" role="dialog" aria-labelledby="CBModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CBModalLabel">@{{formData.editing?'Edit':'Add'}} Coupon Bank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="post" >


                        <!-- Name -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" v-model="formData.name">


                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control" style="resize:none;" rows="5" name="description" v-model="formData.description"></textarea>
                                <span class="help-block">500 characters max.</span>

                            </div>
                        </div>



                        <!-- Date end -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">Coupon codes</label>
                            <div class="col-md-6">

                                <textarea v-model="formData.codes" class="form-control" style="resize:none;" rows="5"></textarea>
                                <span class="help-block" >
                                    Adding multiple coupon codes must be comma separated.
                                </span>




                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Type</label>
                            <div class="col-md-6">
                                <select class="form-control" v-model="formData.type" >
                                    <option value="general">General Use</option>
                                    <option value="single">Single Use</option>

                                </select>
                            </div>
                        </div>

                    </form>

                </div>




                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click.prevent="formData.editing ? updateCouponBank() : createCouponBank()" :disabled="formData.busy">@{{formData.editing ? 'Update' : 'Create'}}</button>
                </div>



            </div>

        </div>
    </div>

    <div class="modal fade" id="deleteCoupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Coupon Bank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this Bank?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click="confirmDelete(idToDelete, indexToDelete)">Confirm Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>









</coupons>
@endsection
