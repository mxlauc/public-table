@extends('layouts.main')

@section('content')
<div class="container pt-5">
    <div class="p-2 p-sm-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-3 py-md-0">
          <h1 class="display-5 fw-bold">
            ¡Vaya!
            <br>
            No ha sido posible encontrar esta página
          </h1>
          <p class="col-md-8 fs-4 my-4">
            Esto puede deberse a que el propietario elimino el contenido o la dirección es incorrecta
          </p>
          <a href="/" class="btn btn-primary">
            Ir a la página de inicio
        </a>
        </div>
      </div>
</div>
@endsection
