<?php

    namespace App\Http\Controllers;

    use App\Sprint;
    use App\Task;
    use App\User;
    use App\UserTask;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Http\Request;

    use App\Http\Requests;
    use Illuminate\Support\Facades\DB;

    class TaskController extends Controller
    {

        use SoftDeletes;

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
        }
        
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index ()
        {
            $lastSprintId = 0;
            if(DB::table('sprint')->count() > 0)
            {
                $lastSprintId = DB::table('sprint')
                                  ->whereNull('deleted_at')
                                  ->orderBy('id', 'desc')
                                  ->first()->id;
                $selectedSprint = $lastSprintId;
            }

            if(!isset($_GET['sprint']) OR !is_numeric($_GET['sprint']))
            {
                $sprintId = '';
            }
            else
            {
                $selectedSprint = $_GET['sprint'];
                $sprintId = $_GET['sprint'];
            }

            $taskList = DB::table ( 'task' )
                            ->join ( 'sprint', 'sprint.id', '=', 'task.sprint_id' )
                            ->leftjoin ( 'usertask', 'usertask.task_id', '=', 'task.id' )
                            ->leftjoin('users', 'users.id', '=', 'usertask.user_id')
                            ->select ( 'task.id as id', 'nr', 'sprint.name as sprint', 'task.name as name',
                                     'task.created_at', 'estimatedtime', 
                                       DB::raw('(SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(timeneeded))) 
                                                 FROM zeiterfassung 
                                                 WHERE zeiterfassung.task_id = usertask.task_id 
                                                 AND zeiterfassung.deleted_at IS NULL) as timeneeded'),
                                       DB::raw('(SELECT GROUP_CONCAT((SELECT name FROM users where id = usertask.user_id) SEPARATOR ", ") 
                                                FROM usertask WHERE task_id = task.id) as erlediger')
                            )
                            ->whereNull('task.deleted_at')
                            ->where('task.sprint_id', '=', $selectedSprint)
                            ->groupBy('task.id')
                            ->paginate (15);

            $sprintList = Sprint::get();



            return view ( 'task.list', compact ( 'taskList', 'selectedSprint', 'sprintList', 'sprintId' ) );
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create ()
        {
            
            $sprintList = [];
            $lastSprintID = 0;
            $userList = User::get();
            if(DB::table('sprint')->count() > 0)
            {
                $lastSprintID = DB::table('sprint')
                                  ->orderBy('id', 'desc')
                                  ->first()->id;
    
                $sprintList = prepareArrayForFormBuilderSelect ( Sprint::get () );
            }


            return view ( 'task.add', compact ( 'sprintList', 'lastSprintID', 'userList' ) );
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store ( Requests\TaskRequest $request )
        {
            $taskInput = $request->except('user');
            
            if(isset($taskInput['estimatedtime']) AND is_numeric(explode(':', $taskInput['estimatedtime'])[0]) AND is_numeric(explode(':', $taskInput['estimatedtime'])[1]))
            {
                $task = Task::create ( $request->except('user') );    
            }
            else
            {
                return redirect('task/create');   
            }
            
            if($request->only('user')['user'] != NULL)
            {
                foreach($request->only('user')['user'] as $user)
                {
                    $usertask = new UserTask();
                    $usertask->task_id = $task->id;
                    $usertask->user_id = $user;
                    $usertask->save();
                }    
            }
            

            return redirect ( 'task/create' );

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
            //
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
            $userList = User::get();
            $sprintList = prepareArrayForFormBuilderSelect ( Sprint::get () );

            $task = Task::find($id);
            $erledigerArr = getErledigerToArr(DB::table('usertask')->where('task_id', '=', $id)->get());

            return view ( 'task.edit', compact ( 'sprintList', 'userList', 'task', 'erledigerArr' ) );
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update ( Requests\TaskRequest $request, $id )
        {
            echo 'hi';
            $taskInput = $request->except('user');

            if(isset($taskInput['estimatedtime']) AND is_numeric(explode(':', $taskInput['estimatedtime'])[0]) AND is_numeric(explode(':', $taskInput['estimatedtime'])[1]))
            {
                $task = Task::find( $id );

                $task->nr = $taskInput['nr'];
                $task->sprint_id = $taskInput['sprint_id'];
                $task->name = $taskInput['name'];
                $task->estimatedtime = $taskInput['estimatedtime'];
                $task->save();
            }
            else
            {
                return redirect('task/create');
            }

            UserTask::where('task_id', $id)->delete();
            if(!empty($request->only('user')['user']))
            {
                foreach ( $request->only ( 'user' )[ 'user' ] as $user )
                {
                    $usertask          = new UserTask();
                    $usertask->task_id = $task->id;
                    $usertask->user_id = $user;
                    $usertask->save ();
                }
            }

            return redirect ( 'task' );

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
            $task = Task::findOrFail($id);
            $task->delete();
            return redirect('task');
        }
    }
