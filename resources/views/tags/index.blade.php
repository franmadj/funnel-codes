@extends('spark::layouts.app')

@section('breadcrumb')
<div class="container">



    <div class="row">

        <div class="col-md-12">


            <div class="app-heading-container app-heading-bordered bottom">
                <ol class="breadcrumb">
                    <li><a href="/home">Home</a></li>

                    <li class="active">Tags</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content')
<tags :user="user" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">



                <div class="panel-heading panel-heading-button">


                    <div class="row">

                        <div class="col-md-6 pull-right">
                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#tagModal" @click="resetModal()">New Tag</button>
                        </div>
                    </div>
                </div>





                <div v-if="!tags.length" class="alert alert-warning" role="alert"><strong>You don't have any tags yet!</strong><br/>Select <strong>New Tag</strong> above to get started.</div>

                <div v-else class="panel panel-default">

                    <div class="panel-body">
                        <div v-if="loaded" class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Color</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" style="min-width: 156px;">Created On</th>
                                        <th scope="col" style="min-width: 147px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="(tag, index) in tags">
                                        <td>
                                            <span class="fa-stack fa-sm" :style="'color: '+tag.color">
                                                <i class="fa fa-circle fa-stack-1x icon-background1"></i>
                                            </span>
                                        </td>
                                        <td>@{{ tag.name }}</td>
                                        <td>@{{formatDate(tag.created_at.date,'short')}}</td>
                                        <td>

                                            <button type="button" class="btn btn-success btn-xs" @click="editTag(tag, index)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</button>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteTag" @click="idToDelete=tag.id, indexToDelete=index"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button> 

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

        <div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="tagModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tagModalLabel">New Tag</h5>
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
                                <label class="col-md-4 control-label">Color</label>
                                <div class="col-md-6">
                                    <chrome-picker v-model="formData.color" />

                                </div>
                            </div>



                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click.prevent="formData.editing ? updateTag() : createTag()" :disabled="formData.busy">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteTag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Tag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to remove this tag?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="confirmDeleteTag(idToDelete, indexToDelete)">Confirm Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</tags>
@endsection
