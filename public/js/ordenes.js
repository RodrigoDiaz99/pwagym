$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    /**bootstrap table del grid de expediente */
    const $gridExpediente = $("#table_ordenes");

    $gridExpediente.bootstrapTable({
        url: routePedidos,
        classes: "table-striped",
        method: "post",
        contentType: "application/x-www-form-urlencoded",
        locale: "es-MX",
        pagination: true,
        pageSize: 10,

        columns: [
            {
                field: "iIDProducto",
                visible: false,
            },
            {
                field: "orden_number",
                title: "#",
            },
            {
                field: "reference_line",
                title: "Referencia",
            },
            {
                field: "estatus",
                title: "Estatus",
            },
            {
                field: "price",
                title: "Total",
            },
            {
                field: "cedicion",
                title: "Acciones",
                formatter: "accionesFormatter",
            },
        ],
    });
    $("#btnClose", "#btnCerrar").on("click", function () {
        $("#cCodeBar").val("");
        $("#price").val("");
    });
});

function accionesFormatter(value, row) {
    let html = "";
    console.log(row);
    //<a href="javascript:void(0);" onclick="subirDocumento('${cTipo}',${iIDSolicitud}, ${iIDAnioFiscal},${lActa},${lApendice},${lDerechos},${lDescripcion},${lEstatutos},${CanRect},${iID},'${inmobiliario}',${lAviso},${iIDControlActa},${lPlanos})" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Modificar Archivos"><i class="fas fa-retweet"></i></a>&nbsp;
    html +=
        '<a href="javascript:void(0);" onclick="detalles('+row.id+')" class="btn btn-round btn-primary btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Modificar Archivos"><i class="fas fa-info-circle"></i></a>&nbsp;';
    switch (row.estatus) {
        case "ENVIADO":
            html +=
            '<a href="javascript:void(0);" onclick="subirDocumento('+row.id+')" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Modificar Archivos"><i class="fas fa-retweet"></i></a>&nbsp;';
            break;
        case "ACEPTADO":
            html +=
            '<a href="javascript:void(0);" onclick="subirDocumento('+row.id+')" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Modificar Archivos"><i class="fas fa-retweet"></i></a>&nbsp;';
            break;
        case "PREPARACION":
            html +=
            '<a href="javascript:void(0);" onclick="subirDocumento('+row.id+')" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Modificar Archivos"><i class="fas fa-retweet"></i></a>&nbsp;';
            break;
        case "CANCELADO":
            html +=
            '<a href="javascript:void(0);" onclick="subirDocumento('+row.id+')" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Modificar Archivos"><i class="fas fa-retweet"></i></a>&nbsp;';
            break;
        case "TERMINADO":
            html +=
            '<a href="javascript:void(0);" onclick="subirDocumento('+row.id+')" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Modificar Archivos"><i class="fas fa-retweet"></i></a>&nbsp;';
            break;

    }
    return html;
}

function detalles(iIDPedido) {
    $.ajax({
      url: routeData,
      type: "post",
      encoding: "UTF-8",
      async: true,
      cache: false,
      data: {
        iIDPedido: iIDPedido,

      },
      beforeSend: function () {
        NProgress.start();
        NProgress.set(0.4);
        Swal.fire({
          title: "Motivo",
          text: "Buscando Motivo de la Suspensión...",
          onOpen: () => {
            swal.showLoading();
          },
        });
      },
      success: function (data) {
        Swal.close();
        NProgress.done();

        modalMotivos(data);

        //  modalMotivos(res,stringified)
      },
      error: function (err) {
        Swal.close();
        alert(err);
        NProgress.done();
        alert("Problemas con el procedimiento.");
      },
    });
  }
