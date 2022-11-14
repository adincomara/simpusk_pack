<!DOCTYPE html>
<html lang="en" class="light-style">

<head>
    <title>Login </title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <link href="{{ asset('inspinia/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ asset('inspinia/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/style.css')}}" rel="stylesheet">
</head>

<body style="background: url('{{ asset('assets/img/bg13.png') }}') no-repeat; background-size:100%;">
    <div class="container">
        {{-- <img src="{{ asset('assets/img/logo_kudus.png') }}" alt="" style="width: 8%;"> --}}
    </div>
    <div class="loginColumns animated fadeInDown" style="margin-top: -4rem">
        <div class="bg-danger d-flex justify-content-start mt-0">
        </div>
        <div class="d-flex justify-content-center text-left mb-5">
            <img src="{{ asset('assets/img/logo_kudus.png') }}" alt="" style="width: 10%" class="text-center">
            <div class="my-auto">
                <h3 class="text-left text-primary my-auto font-weight-light pl-4">Dinas Kesehatan</h3>
                <h2 class="text-left text-primary my-auto font-weight-bold pl-4">Kabupaten Kudus</h2>
            </div>
        </div>
        {{-- <h1 class="text-center text-primary font-weight-bold my-4 ">Kabupaten Kudus</h1> --}}
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="ibox-content b-r-xl">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/img/logo-puskesmas.png') }}" alt="" style="width: 25%"
                            class="text-center">
                    </div>
                    <h3 class="text-center text-primary font-weight-light my-4 mb-0">Login Sistem Puskesmas</h3>
                    @if(session('message'))
                    <div class="alert alert-{{session('message')['status']}}">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        {{ session('message')['desc'] }}
                    </div>
                    @endif
                    <form class="m-t" action="{{route('manage.checklogin')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control b-r-xl" name="email" required="" value="">
                        </div>
                        <div class="form-group">
                            <label class="form-label d-flex justify-content-between align-items-end">
                                <div>Password</div>
                            </label>
                            <input type="password" class="form-control b-r-xl" name="password" required="">
                        </div>
                        <button type="submit"
                            class="btn btn-primary block full-width m-b b-r-xl btn-simpan">Login</button>
                        <hr class="my-auto col-sm-1 d-block" style="background:#1ab394;">
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
