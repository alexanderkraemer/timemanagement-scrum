<?php

namespace App\Http\Controllers;

use App\Task;
use App\UserTask;
use App\Zeiterfassung;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimeController extends Controller
{

    use SoftDeletes;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timeList = DB::table ( 'zeiterfassung' )
                      ->leftjoin ( 'task', 'task.id', '=', 'zeiterfassung.task_id' )
                      ->leftjoin ( 'users', 'users.id', '=', 'zeiterfassung.user_id' )
                      ->select ( 'zeiterfassung.id as id', 'task.name as taskname',
                        'task.nr as tasknr', 'zeiterfassung.id as timeid',
                        'users.name as username', 'timeneeded', 'timestillneeded')
                      ->orderBy('zeiterfassung.id', 'desc')
                      //->where ( 'zeiterfassung.user_id', '=', Auth::user()->id )
                      ->whereNull('zeiterfassung.deleted_at')
                      ->paginate (15);
        return view('time.list', compact('timeList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lastSprintID = DB::table('sprint')
                            ->orderBy('id', 'desc')
                            ->whereNull('deleted_at')
                            ->first();

        if($lastSprintID != NULL)
        {
            $lastSprintID = $lastSprintID->id;
        }
        
        $taskList = prepareArrayForFormBuilderSelect(DB::table ( 'task' )
                                                        ->where('sprint_id', '=', $lastSprintID)
                                                        ->whereIn('id', function ($query) 
                                                        {
                                                            $query->select('task_id')
                                                                  ->from('usertask')
                                                                  ->where('usertask.user_id', '=', Auth::user()->id)
                                                                  ->where('usertask.done', '=', false)
                                                                  ->whereNull('task.deleted_at');
                                                        })
                                                        ->get (), 'nr.name');

        return view('time.add', compact('taskList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\TimeRequest $request)
    {
        $time = Zeiterfassung::create($request->all());

        if($time->timestillneeded == '00:00')
        {
            UserTask::select('*')
                ->where('task_id', '=', $time->task_id)
                ->where('user_id', '=', Auth::user()->id)
                ->update(['done' => true]);
        }

        return redirect('time');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $time = Zeiterfassung::findOrFail($id);
        if($time->user_id == Auth::user()->id)
        {
            $find = UserTask::select('*')
                            ->where('task_id', '=', $time->task_id)
                            ->where('user_id', '=', Auth::user()->id)
                            ->update(['done' => false]);
            $time->delete();
        }

        return redirect('time');
    }
}
