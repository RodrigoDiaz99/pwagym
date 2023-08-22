const $gridExpediente = $("#table_lista");
$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    /**bootstrap table del grid de expediente */

console.log(routeLista);
    $gridExpediente.bootstrapTable({
        url: routeLista,
        classes: "table-striped",
        method: "post",
        contentType: "application/x-www-form-urlencoded",
        locale: "es-MX",
        pagination: true,
        pageSize: 10,
        search:true,
        columns: [
            {
                field: "id",
                visible: false,
            },
            {
                field: "name",
                title: "Nombre",

            },
            {
                field: "code_user",
                title: "codigo",
            },
            {
                field: "username",
                title: "usuario",
                visible:false
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
    console.log(row.estatus);
    //<a href="javascript:void(0);" onclick="estatusChange('${cTipo}',${iIDSolicitud}, ${iIDAnioFiscal},${lActa},${lApendice},${lDerechos},${lDescripcion},${lEstatutos},${CanRect},${iID},'${inmobiliario}',${lAviso},${iIDControlActa},${lPlanos})" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Modificar Archivos"><i class="fas fa-retweet"></i></a>&nbsp;
    html +=
        '<a href="javascript:void(0);" onclick="verPedido(' +
        row.id +
        ')" class="btn btn-round btn-primary btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Ver Pedidos"><i class="fas fa-info-circle"></i></a>&nbsp;';
    switch (row.estatus) {

        case "ENVIADO":
            html +=
                '<a href="javascript:void(0);" onclick="estatusChange(' +
                row.id +
                "," +
                "'AC'" +
                ')" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Aceptar"><i class="fas fa-retweet"></i></a>&nbsp;';
            html +=
                '<a href="javascript:void(0);" onclick="estatusChangeCan(' +
                row.id +
                "," +
                "'CAN'" +
                ')" class="btn btn-round btn-danger btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Rechazar"><i class="fas fa-ban"></i></a>&nbsp;';
            break;
        case "ACEPTADO":
            console.log("entro")
            html +=
                '<a href="javascript:void(0);" onclick="estatusChange(' +
                row.id +
                "," +
                "'PREP'"+
            ')" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Elaboracion"><i class="fas fa-retweet"></i></a>&nbsp;';
            console.log(html)
            break;
        case "PREPARACION":
            html +=
                '<a href="javascript:void(0);" onclick="estatusChange(' +
                row.id +
                "," +
                "'LIS'"+
            ')" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Listo"><i class="fas fa-retweet"></i></a>&nbsp;';
            break;
        case "CANCELADO":
            html +=
                '<a href="javascript:void(0);" onclick="MotivoCanc(' +
                row.id +
                "," +
                "'COMANDERA'"+
            ')" class="btn btn-round btn-danger btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Motivo Cancelado"><i class="fa fa-inbox"></i></a>&nbsp;';
            break;
        case "LISTO":

            html +=
                '<a href="javascript:void(0);" onclick="estatusChange(' +
                row.id +
                "," +
                "'FINALIZADO'"+
            ')" class="btn btn-round btn-warning btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Entregado"><i class="fas fa-retweet"></i></a>&nbsp;';
            break;
    }
    return html;
}

function verPedido(iIDUsuario) {
    $.ajax({
        url: routeData,
        type: "post",
        encoding: "UTF-8",
        async: true,
        cache: false,
        data: {
            iIDUsuario: iIDUsuario,
        },
        beforeSend: function () {
            NProgress.start();
            NProgress.set(0.4);
            Swal.fire({
                title: "Detalles",
                text: "Buscando Datos del Pedido",
                didOpen: () => {
                    swal.showLoading();
                },
            });
        },
        success: function (data) {
            console.log(data);
            Swal.close();
            NProgress.done();

            modalDetalles(data);

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
function modalDetalles(data) {
    console.log(data);
    $("#ModalPedidos").modal("show");

    var ul = document.getElementById("lista-productos");
    var totalSpan = document.getElementById("total-span");

    ul.innerHTML = ""; // Limpia la lista antes de agregar productos

    data.forEach(function (producto) {
        var li = document.createElement("li");
        li.textContent =
            producto.name + " - Cantidad: " + producto.cantidad;
        ul.appendChild(li);
    });

    totalSpan.textContent = "Total $" + data[0].total;
}



function estatusChange(iIDPedido, cEstatus) {
    $.ajax({
        url: routeEstatus,
        type: "post",
        encoding: "UTF-8",
        async: true,
        cache: false,
        data: {
            iIDPedido: iIDPedido,
            cEstatus: cEstatus,
        },
        beforeSend: function () {
            NProgress.start();
            NProgress.set(0.4);
            Swal.fire({
                title: "Aviso",
                text: "Validando Cambios",
                didOpen: () => {
                    swal.showLoading();
                },
            });
        },
        success: function (data) {
            console.log(data);
            Swal.close();
            NProgress.done();
            if (data.lSuccess == true) {
                swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "Estatus actualizado correctamente",
                    confirmButtonText: "Aceptar",
                });
                $gridExpediente.bootstrapTable('removeAll');
                $gridExpediente.bootstrapTable('refresh');
            } else {
                swal.fire({
                    icon: "error",
                    title: "Ups...",
                    text: "No se pudo cambiar el error",
                    confirmButtonText: "Aceptar",
                });
            }

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
function estatusChangeCan(iIDPedido, cEstatus) {
    Swal.fire({
      title: "Detalles",
      text: "Ingrese el motivo de la Cancelacion:",
      input: 'textarea',
      inputLabel: 'Motivo',
      inputPlaceholder: 'Ingrese el motivo aquí...',
      inputAttributes: {
        'aria-label': 'Motivo'
      },
      showCancelButton: true,
      preConfirm: function (motivo) {
        if (!motivo) {
          Swal.showValidationMessage('Debe ingresar un motivo');
        } else {
          enviarSolicitudAjax(iIDPedido, cEstatus, motivo);
        }
      }
    });
  }

  function enviarSolicitudAjax(iIDPedido, cEstatus, motivo) {
    $.ajax({
      url: routeCan,
      type: "post",
      encoding: "UTF-8",
      async: true,
      cache: false,
      data: {
        iIDPedido: iIDPedido,
        cEstatus: cEstatus,
        motivo: motivo // Agregar el motivo al objeto data
      },
      beforeSend: function () {
        NProgress.start();
        NProgress.set(0.4);
        Swal.fire({
          title: "Aviso",
          text: "Validando Cambios",
          didOpen: () => {
            swal.showLoading();
        },
        });
      },
      success: function (data) {
        console.log(data);
        Swal.close();
        NProgress.done();
        if (data.lSuccess == true) {
          swal.fire({
            icon: "success",
            title: "Éxito",
            text: "Estatus actualizado correctamente",
            confirmButtonText: "Aceptar",
          });
          $gridExpediente.bootstrapTable('removeAll');
          $gridExpediente.bootstrapTable('refresh');
        } else {
          swal.fire({
            icon: "error",
            title: "Ups...",
            text: "No se pudo cambiar el error",
            confirmButtonText: "Aceptar",
          });
        }
      },
      error: function (err) {
        Swal.close();
        alert(err);
        NProgress.done();
        alert("Problemas con el procedimiento.");
      },
    });
  }

  function MotivoCanc(iIDPedido, cSistema) {
    $.ajax({
      url: routeMotCan,
      type: "post",
      encoding: "UTF-8",
      async: true,
      cache: false,
      data: {
        iIDPedido: iIDPedido,
        cSistema: cSistema,

      },
      beforeSend: function () {
        NProgress.start();
        NProgress.set(0.4);
        Swal.fire({
          title: "Aviso",
          text: "Buscando Informacion",
          didOpen: () => {
            swal.showLoading();
        },
        });
      },
      success: function (data) {
        console.log(data);
        Swal.close();
        NProgress.done();
        if (data.lSuccess == true) {
          swal.fire({
            icon: "success",
            title: "Motivo",
            text: data.cMensaje,
            confirmButtonText: "Aceptar",
          });

        } else {
          swal.fire({
            icon: "error",
            title: "Ups...",
            text: "No se encontro la informacion",
            confirmButtonText: "Aceptar",
          });
        }
      },
      error: function (err) {
        Swal.close();
        alert(err);
        NProgress.done();
        alert("Problemas con el procedimiento.");
      },
    });
  }
