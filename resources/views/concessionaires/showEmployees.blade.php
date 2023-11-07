@extends('layouts.app')
@section('content')

<head>
  <title>Editar Empleados</title>
  <link rel="stylesheet" href="/css/style.css">
  <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
</head>

<body class="content-body">
  <div class="edit-tables">
    <div>
      <h2>Empleados de {{ $concessionaire->name }}</h2>
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
          <label class="show-label">Empleados asignados</label>
          <select multiple size="10" name="employees[]" class="form-control">

            @foreach($concessionaire->employees as $employee)
            <option value="{{ $employee->id }}">
              {{ $employee->name }}
            </option>
            @endforeach

          </select>
        </div>
      </div>
      <div class="col-sm">
        <form class="form-edit" method='POST' action="{{ route('concessionaires.addEmployees',$concessionaire->id) }}">
          @csrf
          <div class="form-group">
            <label class="show-label">Lista Empleados</label>
            <select multiple class="form-control" size="20" name="employees[]">

              @foreach($employees as $employee)
              <option value="{{ $employee->id }}">
                {{ $employee->name }}
                {{ $employee->concessionaire_id }}
              </option>
              @endforeach
            </select>
            <input class="btn btn-primary" value="Asignar Empleados" type="submit">
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