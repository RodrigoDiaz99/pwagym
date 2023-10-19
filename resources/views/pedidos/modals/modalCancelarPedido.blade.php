<div id="modalCancelarPedido" class="modal fade" tabindex="-1">
    <input id="pedidos_id" type="hidden" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="tituloCancelarPedido" class="modal-title">Cancelar pedido</h5>
                <button id="btnCerrar" type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="motivoCancelacion" class="form-label">Para continuar, especifíque el motivo de la cancelación:</label>
                    <textarea id="motivoCancelacion" class="form-control" name="motivoCancelacion" rows="3" style="resize: none;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </div>
</div>
