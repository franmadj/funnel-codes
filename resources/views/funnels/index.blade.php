@extends('spark::layouts.app')

@section('breadcrumb')
<div class="container">



    <div class="row">

        <div class="col-md-12">


            <div class="app-heading-container app-heading-bordered bottom">
                <ol class="breadcrumb">
                    <li>Home</li>

                </ol>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content')








<home :user="user" inline-template>


    <div class="container">

        <div class="header-box">
            <div class="row">

                <div class="col-md-3 filter-checkboxes">
                    <div class="form-group">
                        <select class="form-control" v-model="filters.expire" @change='filterFunnel(true)'>
                            <option value="any">All</option>
                            <option value="expired">Expired</option>
                            <option value="lowCoupons">Low on coupons</option>
                            <option value="expireSoon">Expiring soon</option>
                        </select>



                    </div>

                </div>

                
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group addedTags">
                        <span v-for="(filterTag, index) in filters.tags" href="#"  :style="{color: filterTag.color}"><input type="checkbox" v-model="filterTag.checked"  @click='filterFunnel(true)'> @{{filterTag.name}}</span>

                    </div>

                </div>
            </div>
        </div>

        <!--        <div class="row">
        
                    <div class="col-md-12">
        <range-datepickers start-date="06-10-2017" end-date="06-20-2017" :bootstrapStyling="false"></range-datepickers>
                    </div>
                        
                </div>-->

        <div class="row">

            <div class="col-md-12">
                <div class="panel-heading panel-heading-button">
                    <div class="row">
                        
                        <div class="col-md-6 pull-right">


                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#funnelModal" @click="resetModal()">New Funnel</button>
                        </div>
                    </div>
                </div>
                <div v-if="!itemsCount" class="alert alert-warning" role="alert"><strong>You don't have any Funnels yet!</strong><br/>Select <strong>New Funnel</strong> above to get started.</div>
                
                <div v-else-if="!results" class="panel panel-default">
                    <div class="panel-body no-results"> 
                        
                    </div>
                    
                </div>

                <div v-else class="panel panel-default">

                    <div class="panel-body"> 

                        <div v-if="loaded" class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th>Name</th>
                                        <th style="min-width: 165px;">From</th>
                                        <th style="min-width: 165px;">To</th>
                                        <th>Redemptions</th>
                                        <th>Number of Coupons</th>
                                        <th style="min-width: 209px;">Actions</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(funnel, index) in funnels">

                                        <td>@{{funnel.name}}</td>
                                        <td>@{{formatDate(funnel.starts_at.date,'short')}}</td>
                                        <td>@{{formatDate(funnel.ends_at.date, 'short')}}</td>
                                        <td>@{{funnel.no_of_redeemed}}</td>
                                        <td>@{{funnel.no_of_coupon}}</td>

                                        <td>
                                            <button type="button" class="btn btn-info btn-xs" @click="viewBankCodes(funnel.id)"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</button>

                                            <button type="button" class="btn btn-success btn-xs" @click="editFunnel(funnel, index)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</button>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteFunnel" @click="idToDelete=funnel.id, indexToDelete=index"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button> 

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





        <div class="modal fade" id="funnelModal" tabindex="-1" role="dialog" aria-labelledby="funnelModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="funnelModalLabel">@{{formData.editing?'Edit':'Add'}} Funnel</h5>
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

                            <!-- date start -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Available From</label>
                                <div class="col-md-6">

                                    <date-picker v-model="formData.starts_at" type="datetime" format="YYYY-MM-DD HH:mm:ss" lang="en"></date-picker>


                                </div>
                            </div>

                            <!-- Date end -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Available To</label>
                                <div class="col-md-6">

                                    <date-picker v-model="formData.ends_at" type="datetime" format="yyyy-MM-dd HH:mm:ss" lang="en"></date-picker>



                                </div>
                            </div>


                            <!-- Date end -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Tags</label>
                                <div class="col-md-6">
                                    <autocomplete anchor="name" label="" v-model="formData.preTag" :classes="{ input: 'form-control', list: 'data-list', item: 'data-list-item' }" :url="siteDomain+'/api/tags'" :on-select="onSelectTag">
                                </autocomplete>

                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Added tags</label>
                            <div v-if="formData.addedTags" class="col-md-6 addedTags">
                                <a v-for="(addedTag, index) in formData.addedTags" href="#" @click.prevent="removeTag(index)" :style="{color: addedTag.color}"><span class="glyphicon glyphicon-trash"></span> @{{addedTag.name}}</a>

                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click.prevent="formData.editing ? updateFunnel() : createFunnel()" :disabled="formData.busy">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteFunnel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Funnel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this Funnel?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click="confirmDeleteFunnel(idToDelete, indexToDelete)">Confirm Delete</button>
                </div>
            </div>
        </div>
    </div>


</div>






</home>
@endsection
