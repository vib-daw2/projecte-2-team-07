@extends('layouts.app')

@section('content')

<head>
  <title>Editar Concesionarios</title>
  <link rel="stylesheet" href="/css/style.css">
  <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
</head>

<body class="content-body">
  <div class="edit-tables">
    <div>
      <h2>Concessionarios de {{ $customer->name }}</h2>
    </div>


    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif


    <div class="row">

      <div class="col-sm">
        <form class="form-edit" method='POST' action="{{ route('customers.detachConcessionaires',$customer->id) }}">
          @csrf
          <div class="form-group">
            <label class="show-label">Concessionarios asignados</label>
            <select multiple size="10" name="concessionaires[]" class="form-control">

              @foreach($customer->concessionaires as $concessionaire)
              <option value="{{ $concessionaire->id }}">
                {{ $concessionaire->name }}
              </option>
              @endforeach

            </select>
            <input type="submit" value="Eliminar Concessionario" class="btn btn-primary">
          </div>
        </form>
      </div>
      <div class="col-sm">
        <form class="form-edit" method='POST' action="{{ route('customers.attachConcessionaires',$customer->id) }}">
          @csrf
          <div class="form-group">
            <label class="show-label">Lista Concessionarios</label>
            <select multiple class="form-control" size="20" name="concessionaires[]">

              @foreach($concessionaires as $concessionaire)
              <option value="{{ $concessionaire->id }}">
                {{ $concessionaire->name }}
                {{ $concessionaire->customer_id }}
              </option>
              @endforeach
            </select>
            <input class="btn btn-primary" value="Asignar Concessionarios" type="submit">
          </div>
        </form>
      </div>

    </div>

    @if (session('success'))
    <div class="alert alert-success">
      <p>{{ session('success') }}</p>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    @endif
  </div>
</body>
@endsection