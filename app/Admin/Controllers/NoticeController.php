<?php

namespace App\Admin\Controllers;


class NoticeController extends Controller {

    //通知列表页面
    public function index(){
        $notices = \App\Notice::all();
        return view('/admin/notice/index',compact('notices'));
    }

    //通知创建页面
    public function create(){
        return view('/admin/notice/create');
    }

    //通知创建操作
    public function store(){

        $this->validate(request(),[
           'title' => 'required|string',
           'content' => 'required|string',
        ]);

        $notice = \App\Notice::create(request(['title','content']));

        //database队列分发
        dispatch(new \App\Jobs\SendMessage($notice));

        return redirect("/admin/notices");
    }


}