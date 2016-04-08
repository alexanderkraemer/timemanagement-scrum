@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sprints
                    <a class="nounderline" href="sprint/create"><span class="glyphicon glyphicon-plus pull-right"></span></a>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-bordered hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nr</th>
                            <th>Beschreibung</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($sprintList as $sprint)
                            @if($i == count($sprintList))
                                <tr class="active success">
                            @else
                                <tr>
                            @endif
                                @if(!DB::table('task')->where('task.sprint_id', '=', $i)->whereNull('task.deleted_at')->exists())
                                    <td><a href="/sprint/{{ $sprint->id }}/delete" onclick="return confirm('Wirklich löschen?');"><i class="glyphicon glyphicon-remove"></i></a></td>
                                @else
                                    <td></td>
                                @endif
                                <td>{{ $sprint->id }}</td>
                                <td>{{ $sprint->name }}</td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $sprintList->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
