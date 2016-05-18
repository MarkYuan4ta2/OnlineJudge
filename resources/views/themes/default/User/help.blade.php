@extends('layouts.app')

@section('title')
    帮助
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/problems.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container main">
        <div>
            <h2>判题系统</h2>
            <h4>判题结果</h4>
            <ul>
                <li>Accepted: 答案符合判题标准</li>
                <li>Runtime Error: 程序运行时出现错误（指针越界，栈溢出，有未处理的异常，主函数返回值非零等）</li>
                <li>Time Limit Exceeded: 程序执行时间超出题目要求</li>
                <li>Memory Limit Exceeded: 程序内存使用超出题目要求</li>
                <li>Compile Error: 程序在编译（包括链接）时出现错误</li>
                <li>Wrong Answer: 程序输出与标准答案不符</li>
                <li>System Error: 判题系统发生故障，请等待重判</li>
                <li>Waiting: 你的提交正在等待处理</li>
            </ul>

            <h2>常见问题</h2>
            <ul>
                <li>无特殊说明，请使用标准输入输出。</li>
            </ul>
        </div>
    </div>
@endsection
