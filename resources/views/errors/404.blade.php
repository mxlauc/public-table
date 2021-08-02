@extends('layouts.main')

@section('content')
<div class="container pt-5">
    <div class="p-2 p-sm-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-3 py-md-0">
          <h1 class="display-5 fw-bold">
            {{__('Wow!')}}
            <br>
            {{__('This page could not be found')}}
          </h1>
          <p class="col-md-8 fs-4 my-4">
            {{__('This may be because the owner removed the content or the address is incorrect')}}
          </p>
          <a href="/" class="btn btn-primary">
            {{__('Go to homepage')}}
        </a>
        </div>
      </div>
</div>
@endsection
