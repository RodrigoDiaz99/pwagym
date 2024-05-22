<div id="modalDetallesPedido" class="modal fade" tabindex="-1">
    <input id="pedidos_id" type="hidden" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="tituloCancelarPedido" class="modal-title">Orden número <b id="iNumeroOrdenDetalle"></b></h5>
                <button id="btnCerrar" type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"
                        aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <b>CLIENTE:</b> <span id="detalleCliente">CLIENTE</span>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <b>ENCARGADO:</b> <span id="detalleEncargado">ENCARGADO</span>
                    </div>
                    <div class="col-md-6">
                        <b>FECHA Y HORA:</b> <span id="detalleDatetime">FECHAHORA</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <b>LINEA DE REFERENCIA:</b> <span id="detalleLineaReferencia">LINEAREFERENCIA</span>
                    </div>
                    <div class="col-md-6">
                        <b>ESTATUS:</b> <span id="detalleEstatus">ESTATUS</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <ul id="detalleProductos">

                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                {{-- <button type="button" class="btn btn-primary">Aceptar</button> --}}
            </div>
        </div>
    </div>
</div>
