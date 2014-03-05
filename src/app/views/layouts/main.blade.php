<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Stock Option Trading Simulator</title>    
        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/main.css')}}
    </head>

    <body>
        <div class="container">
            <h1 class="text-center">Stock Option Trading Simulator</h1>
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <ul class="nav"> 

                            @if(!Auth::check())
                            <li>{{ HTML::link('/', 'Home') }}</li>
                            <li>{{ HTML::link('users/register', 'Register') }}</li>  
                            <li>{{ HTML::link('users/login', 'Login') }}</li>
                            <li><a href="users/login/fb">Login with Facebook</a></li>
                            @else
                            <li>{{ HTML::linkAction('UsersController@getDashboard', 'Dashboard') }}</li>
                            <li>{{ HTML::link('users/logout', 'logout') }}</li>
                            @endif
                        </ul> 
                    </div>
                </div>
            </div>
            <hr />
            <div class="container">
                @if(Session::has('message'))
                <p  class="alert text-center text-warning">{{ Session::get('message') }}</p>
                @endif

            </div>
        </div>
        {{ $content }}
        {{ HTML::script("https://code.jquery.com/jquery-2.1.0.min.js") }}
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/app.js') }}

    </body>
</html>