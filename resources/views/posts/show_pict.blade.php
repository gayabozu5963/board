
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <!-- BootstrapのCSS読み込み -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body style= "background-color: #000022;">
<div id="app" style= "background-color: #000022;">
    <div class="container" style= "background-color: #000022;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" >
                        <br>
                            <img src="{{ asset('storage/image/'.$pict) }}"　style= "width: 100%; background-color: #000022;">
                    </div>
                </div>
        </div>
    </div>
 </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
 
    </body>
</html>
   
   


