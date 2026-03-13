var usu_id = $('#user_idx').val();

$(document).ready(function(){

    $.get('../../controller/visor.php?op=combo_municipios', function(data){
        $('#municipio').html(data);
    });

    $(document).on('click', '#btnfiltrar', function(){
        var municipio = $('#municipio').val().trim();
        var seccion   = $('#seccion').val().trim();
        var volumen   = $('#volumen').val().trim();
        var libro     = $('#libro').val().trim();
        var anio      = $('#anio').val().trim();

        if(municipio === '' || seccion === '' || volumen === '' || libro === '' || anio === ''){
            swal({
                title: 'Campos requeridos',
                text: 'Debe llenar todos los filtros de búsqueda: Municipio, Sección, Volumen, Libro y Año.',
                type: 'warning',
                confirmButtonText: 'Entendido',
                confirmButtonClass: 'btn-warning'
            });
            return;
        }

        buscarPDFs(municipio, seccion, volumen, libro, anio);
    });

    $(document).on('click', '#btntodo', function(){
        $('#municipio').val('');
        $('#seccion').val('');
        $('#volumen').val('');
        $('#libro').val('');
        $('#anio').val('');
        limpiarVisor();
    });

    $(document).on('keypress', '#seccion, #volumen, #libro, #anio', function(e){
        if(e.which === 13){
            $('#btnfiltrar').trigger('click');
        }
    });

});

function buscarPDFs(municipio, seccion, volumen, libro, anio){
    $('#lista-pdfs').html(
        '<div class="text-center" style="margin-top:40px;">'+
        '<i class="fa fa-spinner fa-spin fa-2x" style="color:#337ab7;"></i>'+
        '<p style="margin-top:10px; color:#666;">Buscando documentos...</p>'+
        '</div>'
    );

    $.post('../../controller/visor.php?op=buscar_pdfs', {
        municipio: municipio,
        seccion:   seccion,
        volumen:   volumen,
        libro:     libro,
        anio:      anio
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
        var sinExt   = doc.nombre.replace(/\.pdf$/i, '');
        var partes   = sinExt.split('_');
        var inscripcion = partes.length >= 2 ? partes[partes.length - 2] : '';
        html +=
            '<div class="pdf-item" data-pdf-url="'+doc.url+'" data-pdf-ruta="'+doc.ruta+'" data-pdf-nombre="'+doc.nombre+'" '+
            'style="cursor:pointer; padding:10px 12px; border-bottom:1px solid #f0f0f0; border-radius:3px; transition:background 0.2s;">'+
                '<div style="display:flex; align-items:center;">'+
                    '<i class="fa fa-file-pdf-o" style="color:#d9534f; font-size:22px; flex-shrink:0;"></i>'+
                    '<div style="margin-left:10px; overflow:hidden; flex:1;">'+
                        '<div style="display:flex; align-items:center; justify-content:space-between;">'+
                            '<div style="font-weight:600; font-size:13px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="'+doc.nombre+'">'+doc.nombre+'</div>'+
                            (inscripcion ? '<span style="background:#337ab7; color:#fff; font-size:11px; font-weight:700; padding:2px 7px; border-radius:10px; flex-shrink:0; margin-left:6px;">'+inscripcion+'</span>' : '')+
                        '</div>'+
                        '<div style="font-size:11px; color:#999; margin-top:2px;">'+
                            '<span class="fa fa-folder-o"></span> '+doc.carpeta+
                            (inscripcion ? ' &nbsp;<span class="fa fa-hashtag"></span> <strong style="color:#555;">Inscripción: '+inscripcion+'</strong>' : '')+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>';
    });

    $('#lista-pdfs').html(html);

    $(document).off('click', '.pdf-item').on('click', '.pdf-item', function(){
        var $item  = $(this);
        var url    = $item.data('pdf-url');
        var ruta   = $item.data('pdf-ruta');
        var nombre = $item.data('pdf-nombre');

        swal({
            title: '¿Visualizar documento?',
            text: nombre,
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Sí, abrir',
            confirmButtonClass: 'btn-primary',
            cancelButtonText: 'Cancelar',
            closeOnConfirm: true
        },
        function(isConfirm){
            if(isConfirm){
                $('.pdf-item').css({'background':'', 'border-left':''});
                $item.css({'background':'#e8f0fe', 'border-left':'3px solid #337ab7'});
                abrirPDF(url, ruta, nombre);
            }
        });
    });
}

function abrirPDF(url, ruta, nombre){
    $('#placeholder-visor').hide();
    $('#pdf-iframe').attr('src', url).show();
    $('#titulo-pdf-activo').text(nombre);

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
    $('#lista-pdfs').html(
        '<div id="mensaje-inicial" class="text-center text-muted" style="margin-top:40px;">'+
        '<i class="fa fa-search fa-3x" style="opacity:0.3;"></i>'+
        '<p style="margin-top:10px;">Utilice los filtros para buscar documentos.</p>'+
        '</div>'
    );
    $('#contador-pdf').text('0');
}
