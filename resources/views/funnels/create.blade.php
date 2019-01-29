@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('partials._error')
                <div class="panel panel-default">
                    <div class="panel-heading">New Funnel</div>
                    <div class="panel-body">                   
                        <form class="form-horizontal" role="form" method="post" action="/funnels">
                            {{ csrf_field() }}

                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Description</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" style="resize:none;" rows="5" name="description"></textarea>
                                    <span class="help-block">500 characters max.</span>
                                </div>
                            </div>
                            
                            <!-- date start -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Available From</label>
                                <div class="col-md-6">
                                    <date-picker value="null" name="starts_at"></date-picker>
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>

                            <!-- Date end -->
                            <div class="form-group">
                                <label class="col-md-4 control-label">Available To</label>
                                <div class="col-md-6">
                                    <date-picker value="null" name="ends_at"></date-picker>
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>

                            
                            
                            

                            <!-- Save Button -->
                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-6">
                                    <button type="submit" class="btn btn-primary" @click.prevent="create" :disabled="form.busy">Save</button>
                                </div>
                            </div>
                            
                            

                            {{--TODO: Add Funnel warning, starts at, and ends at fields. --}}

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</home>
@endsection
