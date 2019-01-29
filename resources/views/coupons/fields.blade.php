@extends('spark::layouts.app')



@section('content')

<fields :coupon_bank_id="{{$coupon_bank_id}}" inline-template>

    <div class="container">

        <div class="row">

            <div class="col-md-12">


                <div class="app-heading-container app-heading-bordered bottom">


                    <ol class="breadcrumb">
                        <li><a href="/home">Home</a></li>
                        <li><a href="/funnel/{{$funnelId}}">{{$bankName}}</a></li>
                        <li class="active">Validation</li>
                    </ol>
                </div>
            </div>
        </div>

        






        <div class="row">

            <div class="col-md-12">
                <div class="panel-heading panel-heading-button">
                    
                    
                    <div class="row">
                        
                        
                        <div class="col-md-6 pull-right">


                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#CFModal" @click="resetModal()">New Validation</button>
                        </div>
                    </div>
                    
                    
                    
                   
                
                </div>
                <div v-if="!couponFields.length" class="alert alert-warning" role="alert"><strong>You don't have any Validations yet!</strong><br/>Select <strong>New Validation</strong> above to get started.</div>

                <div v-else class="panel panel-default">

                    <div class="panel-body"> 

                        <div  v-if="loaded" class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th>NAME</th>

                                        <th>TYPE</th>
                                        <th style="min-width: 150px;">REQUIRED</th>
                                        <th style="min-width: 150px;">ACTIONS</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(couponField, index) in couponFields">

                                        <td>@{{couponField.name}}</td>
                                        <td>@{{couponField.field_type}} <br>@{{couponField.validation_type}}</td>
                                        <td>@{{couponField.required}}</td>



                                        <td>
                                            <button type="button" class="btn btn-success btn-xs" @click="editCF(couponField, index)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</button>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteCode" @click="idToDelete=couponField.id, indexToDelete=index"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button> 

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
        
        
        
        <div class="modal fade" id="deleteCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Coupon Filed</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to remove this field?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="confirmDelete(idToDelete, indexToDelete)">Confirm Delete</button>
                    </div>
                </div>
            </div>
        </div>





        <div class="modal fade" id="CFModal" tabindex="-1" role="dialog" aria-labelledby="CFModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CFModalLabel">@{{formData.editing ? 'Edit' : 'New' }} Coupon Field</h5>
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

                            <div class="form-group">
                                <label class="col-md-4 control-label">Description</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="name" v-model="formData.description"></textarea>


                                </div>
                            </div>





                            <div class="form-group">
                                <label class="col-md-4 control-label">Field Type</label>
                                <div class="col-md-6">
                                    <select class="form-control" v-model="formData.field_type" >

                                        <option value="">-- Select Field Type -- </option>
                                        <option value="text">Text</option>
                                        <option value="email">Email</option>
                                        <option value="phone">Phone Number</option>


                                    </select>
                                </div>
                            </div>

                           



                            <div class="form-group">
                                <label class="col-md-4 control-label">Required</label>
                                <div class="col-md-6">
                                    <input type="checkbox" class="custom-control-input" v-model="formData.required">
                                </div>
                            </div>






                        </form>

                    </div>




                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click.prevent="formData.editing ? updateCouponField() : createCouponField()" :disabled="formData.busy">@{{formData.editing ? 'Update' : 'Create'}}</button>
                    </div>



                </div>

            </div>
        </div>
    </div>









</fields>
@endsection
