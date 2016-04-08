@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        User #{{ $user->id }}
                    </div>
                    <div class="panel-body">
                        <div class="form-body">
                            <div class="form-group col-md-12">
                                {!! Form::label('name', 'ID', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {{ $user->id }}
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('name', 'Username', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {{ $user->name }}
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('name', 'E-Mail', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {{ $user->email }}
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('name', 'gearbeitete Gesamtstunden', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    @if(empty($aufgebrachtestundenTimestamp))
                                        0
                                    @else
                                        {{ $aufgebrachtestundenTimestamp }}
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('name', 'Durchschnittsabweichung', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {{ round($schnitt, 2) }} %
                                    <br/>
                                    <small>
                                        Dieser Wert liegt im Idealfall bei 0%<br/>
                                        Positiver Wert bedeudet, dass zu viel Zeit gebraucht wurde, als geschätzt wurde.<br/>
                                        Negativer Wert bedeudet, dass zu wenig Zeit gebraucht wurde, als geschätzt wurde.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger" role="alert">
                    <span class="sr-only">Achtung:</span>
                    Diese Werte werden nur für den aktuellen Sprint berechnet.<br/>
                    Sobald ein neuer Sprint angelegt wurde, gilt der Wert nur für die Tasks dieses einen Sprints!
                </div>
            </div>
        </div>
    </div>
@endsection
