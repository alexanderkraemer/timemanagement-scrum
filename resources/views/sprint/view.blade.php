@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sprint hinzufügen
                    <a class="nounderline" href="sprint/add"><span class="glyphicon-plus pull-right"></span></a>
                </div>
                <div class="panel-body">
                    {!! Form::open(['action' => ['SprintController@destroy', $sprint->id]]) !!}
                    <div class="form-body">
                        <div class="form-group col-md-12">
                            {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {{ $sprint->name }}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('', '', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::submit('Sprint löschen', ['class' => 'btn btn-success']) !!}
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
