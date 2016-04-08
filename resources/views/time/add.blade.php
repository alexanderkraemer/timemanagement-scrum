@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Zeiterfassung
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
                    {!! Form::open(['action' => 'TimeController@store']) !!}
                    <div class="form-body">
                        <div class="form-group col-md-12">
                            {!! Form::label('task_id', 'Task', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::select('task_id', $taskList, null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('timeneeded', 'Time needed', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::time('timeneeded', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('timestillneeded', 'Time still needed', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::time('timestillneeded', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        {!! Form::hidden('user_id', \Illuminate\Support\Facades\Auth::user()->id) !!}
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
