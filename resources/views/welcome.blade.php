<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta Information -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name'))</title>

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>

        <style>
            body, html {
                background: url('/img/spark-bg.png');
                background-repeat: repeat;
                background-size: 300px 200px;
                height: 100%;
                margin: 0;
            }

            .full-height {
                min-height: 100%;
            }

            .flex-column {
                display: flex;
                flex-direction: column;
            }

            .flex-fill {
                flex: 1;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }


            .text-center {
                text-align: center;
            }

            .links {
                padding: 1em;
                text-align: right;
            }

            .links a {
                text-decoration: none;
            }

            .links button {
                background-color: #3097D1;
                border: 0;
                border-radius: 4px;
                color: white;
                cursor: pointer;
                font-family: 'Open Sans';
                font-size: 14px;
                font-weight: 600;
                padding: 15px;
                text-transform: uppercase;
                width: 100px;
            }
            .top-logo{display: none;}
            @media (max-width: 560px){
                .top-logo{
                    height: inherit;
                    float: left;
                    width: 30%;
                    display: inline;
                }
                .center-logo{display: none;}
            }
            @media (max-width: 357px){
                .top-logo{

                    display: none;
                }
                .center-logo{display: block;}
                .center-logo img{width: 50%;}
            }
        </style>
    </head>
    <body>
        <div class="full-height flex-column">
            <nav class="links">
                <img class="top-logo" src="/img/color-logo.png" >
                @if (Auth::check())
                <a href="/home" style="margin-right: 15px;">
                    <button>
                        Home
                    </button>
                </a>
                
                @else
                <a href="/login" style="margin-right: 15px;">
                    <button>
                        Login
                    </button>
                </a>

                <a href="/register">
                    <button>
                        Register
                    </button>
                </a>


                @endif

                
            </nav>

            <div class="flex-fill flex-center center-logo">
                <h1 class="text-center">
                    <img src="/img/color-logo.png">
                </h1>
            </div>
        </div>
    </body>
</html>
