@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        @include('admin.inc.message')
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $row->desc }}</h4>
                        <form class="cmxform" id="signupForm" method="POST" action="{{route('admin.update')}}">
                            @csrf
                            <fieldset>
                                <div class="form-group">
                                    <label for="fullname">Họ và tên</label>
                                    <input id="fullname" value="{{auth()->user()->fullname}}" class="form-control" name="fullname" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input id="username" value="{{auth()->user()->username}}" class="form-control" name="username" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" class="form-control" value="{{auth()->user()->email}}" name="email" type="email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" class="form-control" name="password" type="password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm password</label>
                                    <input id="confirm_password" class="form-control" name="confirm_password"
                                        type="password">
                                </div>
                                
                                <input class="btn btn-primary" type="submit" value="Save">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    {{-- @include('admin.inc.error') --}}
                    <div class="card-body">
                        <h4 class="card-title">Đổi mật khẩu</h4>
                        <form class="cmxform" id="changePassword" action="{{route('admin.change.password')}}" method="POST">
                            @csrf
                            <fieldset>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" name="password" class="form-control" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New password</label>
                                    <input id="new_password" class="form-control" name="new_password" type="password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm password</label>
                                    <input id="confirm_password" class="form-control" name="confirm_password"
                                        type="password">
                                </div>
                                
                            </fieldset>
                            <input class="btn btn-primary" type="submit" value="Save" id="btn_change_password">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
