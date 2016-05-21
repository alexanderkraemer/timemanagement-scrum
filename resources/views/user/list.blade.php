@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        User
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-bordered hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>E-Mail</th>
                                <th>insgesamt Aufgebrachte Zeit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($userList as $user)
                                <tr data-userid="{{ $user->id }}">
                                    <td>{{ $user->id}}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->aufgebrachtestunden }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $userList->links() }}
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

        $('tr[data-userid]').click(function(){
            window.location.href = '/user/' + $(this).data('userid');
        });
    </script>
@endsection