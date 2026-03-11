var usu_id = $('#user_idx').val();

$(document).ready(function(){

    cargarCombos();

    $(document).on('click', '#btnfiltrar', function(){
        var tick_titulo = $('#tick_titulo').val().trim();
        var cat_id = $('#cat_id').val();
        var prio_id = $('#prio_id').val();
        buscarPDFs(tick_titulo, cat_id, prio_id);
    });

    $(document).on('click', '#btntodo', function(){
        $('#tick_titulo').val('');
        $('#cat_id').val('').trigger('change');
        $('#prio_id').val('').trigger('change');
        limpiarVisor();
        buscarPDFs('', '', '');
    });

    $(document).on('keypress', '#tick_titulo', function(e){
        if(e.which === 13){
            $('#btnfiltrar').trigger('click');
        }
    });

});

function cargarCombos(){
    $.post('../../controller/visor.php?op=combo_categorias', function(data){
        $('#cat_id').html('<option label="Seleccionar"></option>' + data);
        $('#cat_id').trigger('change');
    });

    $.post('../../controller/visor.php?op=combo_prioridades', function(data){
        $('#prio_id').html('<option label="Seleccionar"></option>' + data);
        $('#prio_id').trigger('change');
    });
}

function buscarPDFs(titulo, cat_id, prio_id){
    $('#lista-pdfs').html(
        '<div class="text-center" style="margin-top:40px;">'+
        '<i class="fa fa-spinner fa-spin fa-2x" style="color:#337ab7;"></i>'+
        '<p style="margin-top:10px; color:#666;">Buscando documentos...</p>'+
        '</div>'
    );

    $.post('../../controller/visor.php?op=buscar_pdfs', {
        titulo: titulo,
        cat_id: cat_id,
        prio_id: prio_id
    }, function(data){
        data = JSON.parse(data);
        renderizarLista(data);
    });
}

function renderizarLista(documentos){
    $('#contador-pdf').text(documentos.length);

    if(documentos.length === 0){
        $('#lista-pdfs').html(
            '<div class="text-center text-muted" style="margin-top:40px;">'+
            '<i class="fa fa-inbox fa-3x" style="opacity:0.3;"></i>'+
            '<p style="margin-top:10px;">No se encontraron documentos con los filtros seleccionados.</p>'+
            '</div>'
        );
        return;
    }

    var html = '';
    $.each(documentos, function(i, doc){
        html +=
            '<div class="pdf-item" data-pdf-url="'+doc.url+'" data-pdf-ruta="'+doc.ruta+'" data-pdf-nombre="'+doc.nombre+'" '+
            'style="cursor:pointer; padding:10px 12px; border-bottom:1px solid #f0f0f0; border-radius:3px; transition:background 0.2s;">'+
                '<div style="display:flex; align-items:center;">'+
                    '<i class="fa fa-file-pdf-o" style="color:#d9534f; font-size:22px; flex-shrink:0;"></i>'+
                    '<div style="margin-left:10px; overflow:hidden;">'+
                        '<div style="font-weight:600; font-size:13px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="'+doc.nombre+'">'+doc.nombre+'</div>'+
                        '<div style="font-size:11px; color:#999; margin-top:2px;">'+
                            '<span class="fa fa-folder-o"></span> '+doc.categoria+
                            ' &nbsp;|&nbsp; <span class="fa fa-tag"></span> '+doc.prioridad+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>';
    });

    $('#lista-pdfs').html(html);

    $(document).off('click', '.pdf-item').on('click', '.pdf-item', function(){
        $('.pdf-item').css({'background':'', 'border-left':''});
        $(this).css({'background':'#e8f0fe', 'border-left':'3px solid #337ab7'});

        var url    = $(this).data('pdf-url');
        var ruta   = $(this).data('pdf-ruta');
        var nombre = $(this).data('pdf-nombre');

        abrirPDF(url, ruta, nombre);
    });
}

function abrirPDF(url, ruta, nombre){
    $('#placeholder-visor').hide();
    $('#pdf-iframe').attr('src', url).show();
    $('#titulo-pdf-activo').text(nombre);
    $('#btn-descargar-pdf').attr('href', url);
    $('#acciones-pdf').show();

    $.post('../../controller/visor.php?op=registrar_log', {
        usu_id:      usu_id,
        pdf_nombre:  nombre,
        pdf_ruta:    ruta
    });
}

function limpiarVisor(){
    $('#pdf-iframe').attr('src', '').hide();
    $('#placeholder-visor').show();
    $('#titulo-pdf-activo').text('Ningún documento seleccionado');
    $('#acciones-pdf').hide();
    $('#contador-pdf').text('0');
    $('#lista-pdfs').html(
        '<div id="mensaje-inicial" class="text-center text-muted" style="margin-top:40px;">'+
        '<i class="fa fa-search fa-3x" style="opacity:0.3;"></i>'+
        '<p style="margin-top:10px;">Utilice los filtros para buscar documentos.</p>'+
        '</div>'
    );
}
