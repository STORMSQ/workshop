@extends('admin')
@include('alert')
@section('content')

<form action="/admin/check" method="post">
   輸入密碼： <input type="password" name="password">
    <button>登入</button>
    {{csrf_field()}}
</form>

@endsection
