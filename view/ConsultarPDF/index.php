<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Visor - Consultar PDF</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">

			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Consultar PDF</h3>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">

				<!-- Filtros de busqueda -->
				<div class="row" id="viewfiltros">
					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="municipio">Municipio</label>
							<select class="form-control" id="municipio" name="municipio">
								<option value="">-- Seleccione --</option>
							</select>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="seccion">Sección</label>
							<input type="text" class="form-control" id="seccion" name="seccion" placeholder="Ej. 1">
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="volumen">Volumen</label>
							<input type="text" class="form-control" id="volumen" name="volumen" placeholder="Ej. 2">
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="libro">Libro</label>
							<input type="text" class="form-control" id="libro" name="libro" placeholder="Ej. 20">
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="anio">Año</label>
							<input type="text" class="form-control" id="anio" name="anio" placeholder="Ej. 1989">
						</fieldset>
					</div>

					<div class="col-lg-1">
						<fieldset class="form-group">
							<label class="form-label" for="btnfiltrar">&nbsp;</label>
							<button type="button" class="btn btn-rounded btn-primary btn-block" id="btnfiltrar">
								<i class="fa fa-search"></i>
							</button>
						</fieldset>
					</div>

					<div class="col-lg-1">
						<fieldset class="form-group">
							<label class="form-label" for="btntodo">&nbsp;</label>
							<button type="button" class="btn btn-rounded btn-default btn-block" id="btntodo">
								<i class="fa fa-refresh"></i>
							</button>
						</fieldset>
					</div>
				</div>

				<!-- Visor principal: lista izquierda + PDF derecha -->
				<div class="row" id="visor-container" style="margin-top:10px;">

					<!-- Lista de PDFs encontrados -->
					<div class="col-lg-4 col-md-5" id="panel-lista">
						<div style="height:75vh; overflow-y:auto; border:1px solid #e0e0e0; border-radius:4px;">
							<div style="padding:10px 15px; background:#f5f5f5; border-bottom:1px solid #e0e0e0;">
								<span class="fa fa-file-pdf-o" style="color:#d9534f;"></span>
								<strong style="margin-left:5px;">Documentos encontrados</strong>
								<span id="contador-pdf" style="margin-left:8px; background:#6c757d; color:#fff; padding:2px 8px; border-radius:10px; font-size:12px;">0</span>
							</div>
							<div id="lista-pdfs" style="padding:8px;">
								<div id="mensaje-inicial" class="text-center text-muted" style="margin-top:40px;">
									<i class="fa fa-search fa-3x" style="opacity:0.3;"></i>
									<p style="margin-top:10px;">Utilice los filtros para buscar documentos.</p>
								</div>
							</div>
						</div>
					</div>

					<!-- Visor PDF iframe -->
					<div class="col-lg-8 col-md-7" id="panel-visor">
						<div style="height:75vh; border:1px solid #e0e0e0; border-radius:4px; display:flex; flex-direction:column;">
							<div style="padding:10px 15px; background:#f5f5f5; border-bottom:1px solid #e0e0e0; display:flex; align-items:center;">
								<div>
									<span class="fa fa-file-pdf-o" style="color:#d9534f;"></span>
									<strong id="titulo-pdf-activo" style="margin-left:5px;">Ningún documento seleccionado</strong>
								</div>
							</div>
							<div id="contenedor-iframe" style="flex:1; position:relative; overflow:hidden;">
								<div id="placeholder-visor" class="text-center text-muted" style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">
									<i class="fa fa-file-pdf-o fa-5x" style="opacity:0.2; color:#d9534f;"></i>
									<p style="margin-top:15px;">Seleccione un documento de la lista para visualizarlo.</p>
								</div>
								<iframe id="pdf-iframe" src="" style="width:100%; height:100%; border:none; display:none;"></iframe>
							</div>
						</div>
					</div>

				</div>
				<!-- Fin Visor principal -->

			</div>

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>

	<script type="text/javascript" src="consultarpdf.js"></script>
</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>
