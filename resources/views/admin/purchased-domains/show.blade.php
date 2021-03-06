@extends('layouts.dashboard')
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i> Ver datos de la Compra de Dominio</h1>
        <p>Ver Compra de dominio</p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Forms</li>
        <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
      </ul>
    </div>   
    <!-- FIRST SECTION -->
    <section class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <div class="tile-body text-right">
            <a href="{{ route('admin.dominios-comprados.index') }}" class="btn btn-primary float-left">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>Regresar
            </a>
            <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#modalSuspended">Suspender</button>
            <a href="{{ route('admin.dominios-comprados.edit', $purchasedDomain->id) }}" class="btn btn-primary">Editar</a>
          </div>
        </div>
      </div>
    </section>  
    <!-- Modal Delete -->
    @component('components.modal', [ 
      'modalId' => 'modalSuspended', 
      'modalTitle' => 'Eliminar',
      'btnCloseClass' => 'btn btn-danger w-25', 
      'btnCloseTitle' => 'No', 
      'btnSaveClass' => 'btn btn-success w-25', 
      'btnSaveTitle' => 'Sí',
      'FormId' => 'formSuspended',
    ])

      <h5>¿Seguro que quiere suspender el dominio de "{{$purchasedDomain->customer->full_name}}"?</h5>
        <form class="d-none" method="POST" id="formSuspended" action="{{ route('admin.dominios-comprados.destroy', $purchasedDomain->id) }}">
          {{ method_field('DELETE') }}
          {{ csrf_field() }}       
        </form>
    @endcomponent   
    <!-- SECOND SECTION -->
    <section class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <h3 class="tile-title">Datos de la Compra de dominio</h3>
          <hr>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              <strong>{{ session('status') }}</strong>
            </div>
          @endif
        <!-- START TILE -->
            <div class="tile-body">
              <div class="form-group">
                <label>Nombre del Proveedor de Dominio:</label>
                <input type="text" class="form-control" value="{{ $purchasedDomain->domainProvider->company_name }}" readonly>
              </div> 
              <div class="form-group">
                <label>Nombre del Cliente o Empresa:</label>
                <input type="text" class="form-control" value="{{ $purchasedDomain->customer->full_name }}" readonly>
              </div> 
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Fecha de compra:</label>
                  <input type="date" class="form-control" value="{{ $purchasedDomain->start_date }}" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label>Fecha de vencimiento:</label>
                  <input type="date" class="form-control" value="{{ $purchasedDomain->finish_date }}" readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Nombre de dominio:</label>
                  <input type="text" class="form-control" value="{{ $purchasedDomain->domain_name }}" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label>Precio total:</label>
                  <input type="text" class="form-control" value="{{ $purchasedDomain->total_price_in_dollars }} dólares" readonly>
                </div>
              </div>
              <div class="form-group">
                <label>Agregar una descripción sobre el dominio (DNS, soporte, etc):</label>
                <textarea class="form-control" rows="5" readonly>{{ $purchasedDomain->domain_description }}</textarea>
              </div>
              <div class="form-group row">
                <label for="user" class="col-sm-2 col-form-label">Registrado por:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="user" value="{{ $purchasedDomain->user->full_name }}" readonly>
                </div>
              </div>
            </div><!-- /.tile-body -->
        </div><!-- /.tile -->
      </div><!-- /.col-md-8 offset-md-2 -->
    </section><!-- /.row -->
  </main>
@endsection