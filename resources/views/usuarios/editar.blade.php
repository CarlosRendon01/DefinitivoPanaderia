@extends('layouts.app')

@section('content')
<section class="section" style="background-color: #e0e0eb; min-height: 100vh; display: flex; align-items: center;">
    <div class="container custom-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header d-flex align-items-center justify-content-between bg-primary text-white">
                        <a href="{{ url()->previous() }}" class="btn btn-back text-white">
                            <i class="fas fa-arrow-left mr-2"></i> Regresar
                        </a>
                        <h3 class="page__heading text-center flex-grow-1 m-0">
                            <i class="fas fa-user-plus mr-2"></i> Editar Usuario
                        </h3>
                    </div>
                    <div class="card-body p-4 bg-white">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Revise los campos!</strong>
                            @foreach ($errors->all() as $error)
                            <span class="badge badge-danger">{{ $error }}</span>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['usuarios.update', $user->id], 'class' => 'my-4']) !!}
                        <div class="form-group">
                            <label for="name" class="form-label">Nombre</label>
                            {!! Form::text('name', null, ['class' => 'form-control', 'pattern' => '[A-Za-z\s]+', 'title' => 'El nombre debe contener solo letras y espacios', 'required']) !!}
                            <small class="form-text text-muted">El nombre debe contener solo letras y espacios.</small>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">E-mail</label>
                            {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                {!! Form::password('password', ['class' => 'form-control', 'pattern' => '\S*', 'title' => 'El password no debe contener espacios', 'id' => 'password']) !!}
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePasswordVisibility('password')">
                                        <i class="fas fa-eye" id="togglePasswordIcon-password"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password" class="form-label">Confirmar Password</label>
                            <div class="input-group">
                                {!! Form::password('confirm-password', ['class' => 'form-control', 'pattern' => '\S*', 'title' => 'El password no debe contener espacios', 'id' => 'confirm-password']) !!}
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePasswordVisibility('confirm-password')">
                                        <i class="fas fa-eye" id="togglePasswordIcon-confirm-password"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="roles" class="form-control-label">Roles</label>
                            {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'required']) !!}
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block btn-submit">Guardar</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function validateName(input) {
        var regex = /^[a-zA-Z\s]*$/;
        if (!regex.test(input.value)) {
            input.setCustomValidity('El nombre solo debe contener letras y espacios.');
        } else {
            input.setCustomValidity('');
        }
    }

    function togglePasswordVisibility(fieldId) {
        var field = document.getElementById(fieldId);
        var icon = document.getElementById('togglePasswordIcon-' + fieldId);
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    $(document).ready(function() {
        $('.select2').select2();

        $('input[type="text"]').focus(function() {
            $(this).parent().addClass('active');
        }).blur(function() {
            if ($(this).val() === '') {
                $(this).parent().removeClass('active');
            }
        });

        $('input[type="text"]').on('input', function(event) {
            var regex = /[^a-zA-Z\s]/g;
            var newValue = $(this).val().replace(regex, '');
            $(this).val(newValue);
        });
    });
</script>
@endsection

@section('styles')
<style>
    .bg-primary {
        background-color: #4b479c;
    }

    .form-label {
        font-weight: bold;
        color: #4b479c;
        margin-bottom: 5px;
        font-size: 16px;
    }

    .form-control {
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
        transition: all 0.2s ease;
        font-size: 16px;
        background-color: #f9f9f9;
    }

    .form-control:focus {
        border-color: #4b479c;
        box-shadow: 0 0 8px rgba(75, 71, 156, 0.3);
        background-color: #fff;
    }

    .input-group-text {
        cursor: pointer;
    }

    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .card-header {
        padding: 20px;
        background-color: #4b479c;
        border-bottom: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-header .btn-back {
        display: flex;
        align-items: center;
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 8px;
        background-color: rgba(255, 255, 255, 0.1);
        transition: background-color 0.2s ease;
    }

    .card-header .btn-back:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .card-header .page__heading {
        color: #ffffff;
    }

    .card-body {
        padding: 30px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .alert {
        margin-bottom: 20px;
    }

    .btn-submit {
        transition: all 0.3s ease;
        background-color: #4b479c;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        background-color: #3a2c70;
    }

    .btn-submit:focus {
        outline: none;
        box-shadow: 0 0 10px rgba(75, 71, 156, 0.3);
    }

    .section {
        padding: 60px 0;
        background-color: #e0e0eb;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .custom-container {
        max-width: 800px;
        margin: auto;
        border: 3px solid #4b479c;
        border-radius: 15px;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .custom-container:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .custom-container {
            padding: 0 20px;
        }
    }

    .select2-container .select2-selection--single {
        height: 45px;
        border-radius: 8px;
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 45px;
        padding-left: 10px;
        color: #333;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
    }

    .select2-dropdown {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
    }

    .select2-results__option {
        padding: 8px 10px;
    }

    .select2-results__option--highlighted {
        background-color: #4b479c;
        color: #fff;
    }
</style>
@endsection
