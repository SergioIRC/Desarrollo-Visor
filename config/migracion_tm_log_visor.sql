ALTER TABLE `tm_log_visor`
  DROP FOREIGN KEY `fk_log_usuario`;

ALTER TABLE `tm_log_visor`
  DROP COLUMN `pdf_id`,
  CHANGE COLUMN `fech_consulta` `fech_evento` datetime NOT NULL DEFAULT current_timestamp(),
  ADD COLUMN `usu_nombre` varchar(150) NOT NULL AFTER `usu_id`,
  ADD COLUMN `detalle_busqueda` text NULL AFTER `usu_nombre`,
  ADD COLUMN `pdf_nombre` varchar(255) NULL AFTER `detalle_busqueda`,
  ADD COLUMN `pdf_ruta` text NULL AFTER `pdf_nombre`,
  ADD COLUMN `accion` enum('busqueda','consulta','impresion') NOT NULL DEFAULT 'consulta' AFTER `pdf_ruta`;

ALTER TABLE `tm_log_visor`
  DROP KEY `fk_log_pdf`,
  ADD KEY `idx_log_accion` (`accion`),
  ADD KEY `idx_log_fecha` (`fech_evento`);

ALTER TABLE `tm_log_visor`
  ADD CONSTRAINT `fk_log_usuario` FOREIGN KEY (`usu_id`) REFERENCES `tm_usuario` (`usu_id`);
