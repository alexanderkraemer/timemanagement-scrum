@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tasks
                        <a class="nounderline" href="task/create"><span
                                    class="glyphicon glyphicon-plus pull-right"></span></a>
                    </div>
                    <div class="panel-body">
                        @if(count($sprintList) > 1)
                        <h4 style="margin:0;">Sprint:</h4>
                        <ul class="pagination">
                                @foreach($sprintList as $sprint)
                                    @if(!isset($_GET['sprint']) OR !is_numeric($_GET['sprint']))
                                        @if($selectedSprint == $sprint->id)
                                            <li class="active"><span>{{ $sprint->name }}</span></li>
                                        @else
                                            <li><a href="http://time.alexanderkraemer.com/task?<?php 
                                            if(isset($_GET['page']) AND is_numeric($_GET['page']))
                                            {
                                                echo "page=". $_GET['page'] . "&";
                                            }
                                                
                                            ?>sprint={{ $sprint->id }}">{{ $sprint->name }}</a></li>
                                        @endif
                                    @else
                                        @if($_GET['sprint'] == $sprint->id)
                                            <li class="active"><span>{{ $sprint->name }}</span></li>
                                        @else
                                            <li><a href="http://time.alexanderkraemer.com/task?<?php 
                                            if(isset($_GET['page']) AND is_numeric($_GET['page']))
                                            {
                                                echo "page=". $_GET['page'] . "&";
                                            }
                                                
                                            ?>sprint={{ $sprint->id }}">{{ $sprint->name }}</a></li>
                                        @endif
                                    @endif
                                @endforeach
                        </ul>
                        @endif
                        <table class="table table-responsive table-bordered hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Sprint</th>
                                <th>Task-Nr</th>
                                <th>Name</th>
                                <th>Erstellt am</th>
                                <th>Geschätzte Zeit</th>
                                <th>Gebrauchte Zeit</th>
                                <th>Erledigung durch</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($taskList as $task)
                                <tr data-taskid="{{ $task->id }}">
                                    <td>
                                        @if(!DB::table('zeiterfassung')
                                                ->join('task', 'task.id', '=', 'zeiterfassung.task_id')
                                                ->where('task.id', '=', $task->id)
                                                ->where('task.sprint_id', '=', $selectedSprint)
                                                ->whereNull('zeiterfassung.deleted_at')
                                                ->exists()
                                            )
                                            <a href="/task/{{ $task->id }}/delete"
                                               onclick="return confirm('Wirklich löschen?');"><i
                                                        class="glyphicon glyphicon-remove"></i></a>
                                        @endif
                                    </td>
                                    <td>{{ $task->id }}</td>
                                    <td>{{ $task->sprint }}</td>
                                    <td>{{ $task->nr }}</td>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ dateFromTimestamp($task->created_at) }}</td>
                                    <td>{{ $task->estimatedtime }}</td>
                                    <td>{{ timeFromTimestamp($task->timeneeded) }}</td>
                                    <td>{{ $task->erlediger }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $taskList->appends([ 'sprint' => $sprintId ])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $('tbody tr').hover(function() {
            $(this).css('cursor','pointer');
        });

        $('tr[data-taskid]').click(function(){
            window.location.href = '/task/' + $(this).data('taskid') + '/edit';
        });
    </script>
@endsection