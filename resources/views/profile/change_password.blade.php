<!-- Modal para cambiar contraseña -->
<div id="changePasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Contraseña</h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id="changePasswordForm" action="{{ route('usuarios.changePassword') }}">
                <div class="modal-body">
                    <div id="successAlert" class="alert alert-success d-none">
                        Contraseña actualizada con éxito.
                    </div>
                    <div id="errorAlert" class="alert alert-danger d-none">
                        <ul id="errorList"></ul>
                    </div>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Contraseña Actual:</label><span class="required">*</span>
                            <div class="input-group">
                                <input class="form-control" id="pfCurrentPassword" type="password" name="current_password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="icon-ban icons"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Nueva Contraseña:</label><span class="required">*</span>
                            <div class="input-group">
                                <input class="form-control" id="pfNewPassword" type="password" name="new_password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="icon-ban icons"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Confirmar Contraseña:</label><span class="required">*</span>
                            <div class="input-group">
                                <input class="form-control" id="pfNewConfirmPassword" type="password" name="new_password_confirmation" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="icon-ban icons"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary" id="btnPrPasswordEditSave" data-loading-text="<span class='spinner-border spinner-border-sm'></span> Procesando...">Guardar</button>
                        <button type="button" class="btn btn-light ml-1" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#changePasswordForm').on('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting normally

            var currentPassword = $('#pfCurrentPassword').val();
            var newPassword = $('#pfNewPassword').val();
            var confirmPassword = $('#pfNewConfirmPassword').val();

            // Limpiar mensajes de error anteriores
            $('#errorAlert').addClass('d-none');
            $('#errorList').empty();

            // Validar si las contraseñas nuevas coinciden
            if (newPassword !== confirmPassword) {
                $('#errorList').append('<li>Las contraseñas no coinciden</li>');
                $('#errorAlert').removeClass('d-none');
                return;
            }

            // Submit the form via AJAX
            $.ajax({
                url: $('#changePasswordForm').attr('action'),
                type: 'POST',
                data: $('#changePasswordForm').serialize(),
                success: function(response) {
                    $('#successAlert').removeClass('d-none');
                    setTimeout(function() {
                        $('#changePasswordModal').modal('hide');
                        $('#successAlert').addClass('d-none');
                        $('#changePasswordForm')[0].reset();
                    }, 2000);
                },
                error: function(response) {
                    if (response.responseJSON && response.responseJSON.errors) {
                        var errors = response.responseJSON.errors;
                        for (var error in errors) {
                            $('#errorList').append('<li>' + errors[error][0] + '</li>');
                        }
                        $('#errorAlert').removeClass('d-none');
                    }
                }
            });
        });
    });
</script>
