@extends('layouts.app')

@section('content')
<div>
<pre>
 @foreach ($errors->all() as $error)
                             
                                        
                                        
                                        {{ $error }}
                                  
@endforeach
</pre>
</div>
  <div class="content">
            <div class="container-fluid">
                 <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                        
                        <div class="form-group{{ count($errors)>0 ? '$errors' : '' }}">

                                @foreach ($errors->all() as $error)
                                    <span class="help-block">
                                        <strong>{{ $error }}</strong>
                                    </span>
                                @endforeach

                        </div>


                            <div class="row-fluid">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="card">
                                        <div class="header">
                                            <h4 class="title">Регистрация</h4>
                                        </div>
                                        <div class="content">
                                            <form>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Ф.И.О</label>
                                                            <input type="text" class="form-control" placeholder="name" name="name" value="{{ old('name') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Логин</label>
                                                            <input type="text" class="form-control" placeholder="Username" name="login" value="{{ old('login') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputemail1">Email</label>
                                                            <input type="email" class="form-control" placeholder="email" name="email" value="{{ old('email') }}"  required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Предприятие</label>
                                                            {{ Form::select('firm', $firms, old('firm'),['class'=> 'selectpicker form-control']) }}
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Телефон</label>
                                                            <input type="text" class="form-control" placeholder="7-911-111-11-11" name='phone' value="{{ old('phone') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Id Telegram</label>
                                                            <input type="text" class="form-control" placeholder="" name="telegram" value="{{ old('telegram') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                            
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Пароль</label>
                                                            <input id="password" type="password" class="form-control" name="password" required>

                                                            @if ($errors->has('password'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                </span>
                                                            @endif
                                                         </div>   
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="password-confirm" class=" control-label">Еще раз</label>

                                                        
                                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                                <div class="clearfix"></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </form>
            </div>
        </div>
@endsection