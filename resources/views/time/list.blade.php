@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Time
                    <a class="nounderline" href="time/create"><span class="glyphicon glyphicon-plus pull-right"></span></a>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-bordered hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Task-Nr</th>
                            <th>Taskname</th>
                            <th>Username</th>
                            <th>Datum</th>
                            <th>Gebrauchte Zeit</th>
                            <th>Verbleibende Zeit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($timeList as $time)
                            <tr>
                                <td>
                                    @if(DB::table('zeiterfassung')->where('zeiterfassung.id', '=', $time->timeid)->where('user_id', '=', \Illuminate\Support\Facades\Auth::user()->id)->exists())
                                        <a href="/time/{{ $time->id }}/delete" onclick="return confirm('Wirklich löschen?');"><i class="glyphicon glyphicon-remove"></i></a>
                                    @endif
                                </td>
                                <td>{{ $time->tasknr }}</td>
                                <td>{{ $time->taskname }}</td>
                                <td>{{ $time->username }}</td>
                                <td>{{ dateFromTimestamp($time->date) }}</td>
                                <td>{{ $time->timeneeded }}</td>
                                <td>{{ $time->timestillneeded }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $timeList->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
