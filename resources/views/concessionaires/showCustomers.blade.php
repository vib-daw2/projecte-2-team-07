@extends('layouts.app')
@section('content')
<head>
  <title>Editar Clientes</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
</head>

<body class="content-body">
  <div class="edit-tables">
    <div>
      <h2>Clients de {{ $concessionaire->name }}</h2>
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
        <form class="form-edit" method='POST' action="{{ route('concessionaires.detachCustomers',$concessionaire->id) }}">
          @csrf
          <div class="form-group">
            <label class="show-label">Clients assignats</label>
            <select multiple size="10" name="customers[]" class="form-control">

              @foreach($concessionaire->customers as $customer) {
              <option value="{{ $customer->id }}">
                {{ $customer->name }}
              </option>
              @endforeach

            </select>
            <input type="submit" value="Treure Clients" class="btn btn-primary">
          </div>
        </form>

      </div>
      <div class="col-sm">
        <form class="form-edit" method='POST' action="{{ route('concessionaires.attachCustomers',$concessionaire->id) }}">
          @csrf
          <div class="form-group">
            <label class="show-label">Llista Clients</label>
            <select multiple class="form-control" size="20" name="customers[]">

              @foreach($customers as $customer) 
              <option value="{{ $customer->id }}">
                {{ $customer->name }}
              </option>
              @endforeach
            </select>
            <input class="btn btn-primary" value="Assignar Clients" type="submit">
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