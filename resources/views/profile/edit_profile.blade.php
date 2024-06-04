<!-- Modal para editar perfil de usuario -->
<div id="EditProfileModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Contenido del modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Perfil</h5>
                <button type="button" aria-label="Cerrar" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id="editProfileForm" action="{{ route('usuarios.updateProfile') }}">
                <div class="modal-body">
                    <div id="editProfileSuccessAlert" class="alert alert-success d-none">
                        Perfil actualizado con éxito.
                    </div>
                    <div id="editProfileErrorAlert" class="alert alert-danger d-none">
                        <ul id="editProfileErrorList"></ul>
                    </div>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Nombre:</label><span class="required">*</span>
                            <input type="text" name="name" id="pfName" class="form-control" required autofocus tabindex="1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Correo Electrónico:</label><span class="required">*</span>
                            <input type="email" name="email" id="pfEmail" class="form-control" required tabindex="3">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary" id="btnPrEditSave" data-loading-text="<span class='spinner-border spinner-border-sm'></span> Procesando..." tabindex="5">Guardar</button>
                        <button type="button" class="btn btn-light ml-1 edit-cancel-margin margin-left-5" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#editProfileForm').on('submit', function(event) {
            event.preventDefault(); // Prevenir el envío normal del formulario

            // Limpiar mensajes de error anteriores
            $('#editProfileErrorAlert').addClass('d-none');
            $('#editProfileErrorList').empty();
            $('#editProfileSuccessAlert').addClass('d-none');

            // Enviar el formulario vía AJAX
            $.ajax({
                url: $('#editProfileForm').attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editProfileSuccessAlert').removeClass('d-none');
                    setTimeout(function() {
                        $('#EditProfileModal').modal('hide');
                        $('#editProfileSuccessAlert').addClass('d-none');
                        $('#editProfileForm')[0].reset();
                    }, 2000);
                },
                error: function(response) {
                    if (response.responseJSON && response.responseJSON.errors) {
                        var errors = response.responseJSON.errors;
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                $('#editProfileErrorList').append('<li>' + errors[key][0] + '</li>');
                                if (key === 'email') {
                                    $('#pfEmail').addClass('is-invalid');
                                } else if (key === 'name') {
                                    $('#pfName').addClass('is-invalid');
                                }
                            }
                        }
                        $('#editProfileErrorAlert').removeClass('d-none');
                    } else {
                        $('#editProfileErrorList').append('<li>Ocurrió un error inesperado. Por favor, inténtelo de nuevo más tarde.</li>');
                        $('#editProfileErrorAlert').removeClass('d-none');
                    }
                }
            });
        });

        $('#pfEmail').on('input', function() {
            $(this).removeClass('is-invalid');
        });

        $('#pfName').on('input', function() {
            $(this).removeClass('is-invalid');
        });
    });
</script>
