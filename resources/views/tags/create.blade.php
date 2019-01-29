@extends('spark::layouts.app')

@section('content')
    <home :user="user" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @include('partials._error')
                    <div class="panel panel-default">
                        <div class="panel-heading">New Tag</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="post" action="/tags">
                                {{ csrf_field() }}

                                <!-- Name -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Name</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" placeholder="Ex: Black Friday">
                                        <span class="help-block">
                                    </span>
                                    </div>
                                </div>

                                <!-- Color -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Color</label>
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            @foreach($colors as $color)
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="color{{ $color->id }}">
                                                            <span class="fa-stack fa-sm" style="color: {{ $color->color }};">
                                                                <i class="fa fa-circle fa-stack-1x icon-background1"></i>
                                                            </span>
                                                            {{ ucfirst($color->color) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </home>
@endsection
