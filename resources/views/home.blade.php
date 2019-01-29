@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (count($funnels) !== 0)
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle m-b-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            All Funnels <span class="glyphicon glyphicon-chevron-down"></span></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Show All</a>
                            <a class="dropdown-item" href="#"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;&nbsp;Expiring soon</a>
                            <a class="dropdown-item" href="#"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;&nbsp;Low coupons</a>
                            <a class="dropdown-item" href="#"><span class="glyphicon glyphicon-remove-circle"></span>&nbsp;&nbsp;Expired</a>
                        </div>
                    </div>
                    @if(count($tags) !== 0)
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle m-b-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            All Tags <span class="glyphicon glyphicon-chevron-down"></span></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Show All</a>
                            @foreach($tags as $tag)
                                {{--TODO: Filter tags --}}
                                <a class="dropdown-item" href="/home">
                                    <span class="fa-stack fa-sm" style="color: {{ $tag->color }};">
                                        <i class="fa fa-circle fa-stack-1x icon-background1"></i>
                                    </span>&nbsp;&nbsp;{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endif
                <a href="{{ url('/funnels/create') }}" class="btn btn-primary pull-right m-b-sm">New Funnel</a>
                @if (count($funnels) === 0)
                    <div class="alert alert-warning" role="alert"><strong>You don't have any funnels yet!</strong><br/>Select <strong>New Funnel</strong> above to get started.</div>
                @else
                    <div class="panel panel-default">
                        <div class="panel-heading">Funnels</div>
                    <div class="panel-body">
                        <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Status</th>
                            <th scope="col">Name</th>
                            <th scope="col">Created On</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($funnels as $funnel)
                                <tr>
                                    <td>
                                        <span class="fa-stack fa-sm" style="color: {{ $funnel->status }};">
                                            <i class="fa fa-circle fa-stack-1x icon-background1"></i>
                                        </span>
                                    </td>
                                    <td>{{ $funnel->name }}</td>
                                    <td>{{ $funnel->created_at }}</td>
                                    <td>
                                        <a href="{{ url('/funnels/' . $funnel->id ) }}" class="btn btn-warning btn-xs">Manage</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <div class="text-center">{{ $funnels->links() }}</div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</home>
@endsection
