@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Task bearbeiten
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
                    {!! Form::open(['url' => '/task/' . $task->id . '', 'method' => 'put']) !!}
                    <div class="form-body">
                        <div class="form-group col-md-12">
                            {!! Form::label('nr', 'Nr', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::text('nr', $task->nr, ['class' => 'form-control', 'placeholder' => 'Nr']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('sprint_id', 'Sprint', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::select('sprint_id', $sprintList, $task->sprint_id, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::text('name', $task->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('estimatedtime', 'Geschätzte Zeit', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                {!! Form::text('estimatedtime', $task->estimatedtime, ['class' => 'form-control', 'placeholder' => '--:--']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('user[to][]', 'Erlediger', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-10">
                                <label class="col-lg-1">
                                    @if(count($erledigerArr) == 7)
                                        {!! Form::checkbox('', null, 1, ['id' => 'selectall']) !!}
                                    @else
                                        {!! Form::checkbox('', null, 0, ['id' => 'selectall']) !!}
                                    @endif
                                    <br/>
                                    ALL
                                </label>
                                @foreach($userList as $user)
                                <label class="col-lg-1">
                                    @if(in_array($user->id, $erledigerArr))
                                        {!! Form::checkbox('user[]', $user->id, 1, ['class' => 'checkboxselect']) !!}
                                    @else
                                        {!! Form::checkbox('user[]', $user->id, null, ['class' => 'checkboxselect']) !!}
                                    @endif
                                    <br/>
                                    {{ $user->name }}
                                </label>
                                @endforeach
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

@section('scripts')
    <script>
        $('#selectall').click(function(event) {  //on click
            if(this.checked) { // check select status
                $('.checkboxselect').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"
                });
            }else{
                $('.checkboxselect').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"
                });
            }
        });
    </script>
@endsection