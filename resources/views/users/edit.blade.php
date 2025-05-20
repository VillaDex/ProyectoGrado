@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header">
            <h5 class="mb-0">Editar Usuario</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nueva Contraseña</label>
                    <input type="password" name="password" class="form-control">
                    <small class="text-muted">Dejar en blanco si no quieres cambiar la contraseña.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
</div>
@endsection