@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sprint hinzufügen
                    <a class="nounderline" href="sprint/add"><span class="glyphicon-plus pull-right"></span></a>
                </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::open(['action' => 'SprintController@store']) !!}
                    <div class="form-body">
                        <div class="form-group col-md-12">
                            {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('maxtime', 'Max Time', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::text('maxtime', null, ['class' => 'form-control', 'placeholder' => 'Max Time']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('', '', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
                                {!! Form::reset('Cancel', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
