ALTER TABLE `tm_log_visor`
  ADD COLUMN `detalle_busqueda` text NULL AFTER `usu_nombre`,
  MODIFY COLUMN `pdf_nombre` varchar(255) NULL,
  MODIFY COLUMN `pdf_ruta` text NULL,
  MODIFY COLUMN `accion` enum('busqueda','consulta','impresion') NOT NULL DEFAULT 'consulta';
