@extends('layouts.app')
@section('content')

<head>
  <title>Editar Vehiculos</title>
  <link rel="stylesheet" href="/css/style.css">
  <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
</head>

<body class="content-body">
  <div class="edit-tables">
    <div>
      <h2>Vehiculos de {{ $concessionaire->name }}</h2>
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
        <div class="form-group">
          <label class="show-label">Vehiculos asignados</label>
          <select multiple size="10" name="vehicles[]" class="form-control">

            @foreach($concessionaire->vehicles as $vehicle)
            <option value="{{ $vehicle->id }}">
              {{ $vehicle->name }}
            </option>
            @endforeach

          </select>
        </div>
      </div>
      <div class="col-sm">
        <form class="form-edit" method='POST' action="{{ route('concessionaires.addVehicles',$concessionaire->id) }}">
          @csrf
          <div class="form-group">
            <label class="show-label">Lista Vehiculos</label>
            <select multiple class="form-control" size="20" name="vehicles[]">

              @foreach($vehicles as $vehicle)
              <option value="{{ $vehicle->id }}">
                {{ $vehicle->name }}
                {{ $vehicle->concessionaire_id }}
              </option>
              @endforeach
            </select>
            <input class="btn btn-primary" value="Asignar vehiculos" type="submit">
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