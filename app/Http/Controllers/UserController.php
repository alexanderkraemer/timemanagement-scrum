<?php

    namespace App\Http\Controllers;

    use App\User;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Http\Request;

    use App\Http\Requests;
    use Illuminate\Support\Facades\DB;

    class UserController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct ()
        {
            $this->middleware ( 'auth' );
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index ()
        {
            $userList = DB::table ( 'users' )
                          ->leftjoin ( 'zeiterfassung', 'zeiterfassung.user_id', '=', 'users.id' )
                          ->leftjoin ( 'task', 'task.id', '=', 'zeiterfassung.task_id' )
                          ->select ( 'users.id as id', 'users.name as name', 'users.email as email',
                                     DB::raw ( '(SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `timeneeded` ) ) ) FROM zeiterfassung WHERE user_id = users.id) as aufgebrachtestunden' ) )
                          ->groupBy ( 'users.id' )
                          ->paginate ( 15 );

            return view ( 'user.list', compact ( 'userList' ) );
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create ()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store ( Request $request )
        {
            //
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show ( $id )
        {
            $user                = User::findOrFail ( $id );
            $aufgebrachtestundenTimestamp = 0;
            $schnitt = 0;
            if(DB::table('sprint')->count() > 0)
            {
                $lastSprintID = DB::table('sprint')
                                  ->whereNull('deleted_at')
                                  ->orderBy('id', 'desc')
                                  ->first()->id;
    

                

                $aufgebrachtestundenTimestamp = DB::select ( DB::raw ( 'SELECT SEC_TO_TIME(SUM( TIME_TO_SEC( `timeneeded` ) + TIME_TO_SEC( `timestillneeded` ) )) as aufgebrachtestunden 
                                                               FROM zeiterfassung LEFT JOIN task ON task.id = zeiterfassung.task_id 
                                                               WHERE task.sprint_id = ' . $lastSprintID . ' and user_id = ' . $id ) )[ 0 ]->aufgebrachtestunden;

                $aufgebrachtestunden = DB::select ( DB::raw ( 'SELECT SUM( TIME_TO_SEC( `timeneeded` ) + TIME_TO_SEC( `timestillneeded` ) ) as aufgebrachtestunden 
                                                               FROM zeiterfassung LEFT JOIN task ON task.id = zeiterfassung.task_id 
                                                               WHERE task.sprint_id = ' . $lastSprintID . ' and user_id = ' . $id ) )[ 0 ]->aufgebrachtestunden;


                $geschaetzteZeit = DB::select ( DB::raw ( 'SELECT (
                        SUM((SELECT (SUM( TIME_TO_SEC( `estimatedtime` ) )) from task where id = t.id)
                        /
                        (SELECT count(*) from usertask where task_id = t.id)
                        ))
                as calc FROM task t') )[0]->calc;
                if($geschaetzteZeit == 0)
                {
                    $schnitt = 0;
                }
                else
                {
                    $schnitt = (($aufgebrachtestunden/$geschaetzteZeit) - 1) * 100;
                }
                
            }

            return view ( 'user.view', compact ( 'user', 'aufgebrachtestundenTimestamp' , 'schnitt') );
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function edit ( $id )
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update ( Request $request, $id )
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy ( $id )
        {
            //
        }
    }
