<?php

namespace App\Admin\Controllers;

use app\admin\model\Topic;

class TopicController extends Controller {

    //专题列表页面
    public function index(){
        $topics = \App\Topic::all();
        return view('/admin/topic/index',compact('topics'));
    }

    //专题创建页面
    public function create(){
        return view('/admin/topic/create');
    }

    //专题创建操作
    public function store(){

        $this->validate(request(),[
           'name' => 'required|string',
        ]);

        \App\Topic::create(['name' => request('name')]);

        return redirect("/admin/topics");
    }

    //删除专题
    public function destroy(\App\Topic $topic){
        $topic->delete();

        return [
            'error' => 0,
            'msg' => ''
        ];
    }


}