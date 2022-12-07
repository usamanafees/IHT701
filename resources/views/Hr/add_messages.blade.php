@extends('partials.main')
<!DOCTYPE html>

<head>
  <title>Pusher Test</title>
  {{-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{asset('js/app.js')}}"></script>
  @section('javascript')
  <script>
    Echo.private('home.3')
    .listen('BroadCastMessage', (e) =>{
      alert("aaaaaaaaaaaaa");
      console.log(e);
    });
  </script>
  @endsection
</head>
<body>
  <div id="app">

  </div>

</body>