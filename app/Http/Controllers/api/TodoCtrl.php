<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Todo;
use Validator;

class TodoCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Todo::orderBy('id', 'desc')->get();
        return view('todo.todo_data',[
            'datas' => $datas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reqs = request()->all();
        $rule = [
            'task' => 'required',
        ];
        $errorMessage = [
            'task.required' => '沒有輸入工作事項',
        ];
        // make (要驗證的資料, 規則,  錯誤訊息);
        $validator = Validator::make($reqs, $rule, $errorMessage); 
        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        };

        Todo::create([
            'task' => $reqs['task'],
        ]);

        return [
            'success' => true,
            'message' => '新增成功',
        ];
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
        return Todo::find($id);
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
        // 更動狀態
        if ($request->isMethod('patch')) {
            $existTodo = Todo::find($id);
            if ($existTodo) {
                $existTodo->update([
                    'is_completed' => true,
                    'completed_at' => Carbon::now(),
                ]);
                return [
                    'success' => true,
                    'message' => '更新完成'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'todo 沒發現',
                ];
            }
        }
        // 兩者更新
        if ($request->isMethod('put')) {
            $reqs = request()->all();

            $rule = [
                'task' => 'required',
            ];

            $errorMessage = [
                'task.required' => '沒有輸入工作事項',
            ];

            // make (要驗證的資料, 規則,  錯誤訊息);
            $validator = Validator::make($reqs, $rule, $errorMessage); 
            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            };

            $existTodo = Todo::find($id);
            if ($existTodo) {
                $existTodo->update([
                    'task' => $reqs['task'],
                    'is_completed' => isset($reqs['complete']) ? true : false,
                    'completed_at' => isset($reqs['complete']) ?  Carbon::now() : null,
                ]);
                return [
                    'success' => true,
                    'message' => '更新完成'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'todo 沒發現',
                ];
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existTodo = Todo::find($id);
        if ($existTodo) {
            $existTodo->delete();
            return [
                'success' => true,
                'message' => '已刪除完成',
            ];  
        } else {
            return [
                'success' => false,
                'message' => '並無找到資料',
            ];

        }
    }
}
