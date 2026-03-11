-- ============================================================
-- Tablas necesarias para el Visor de PDFs
-- Base de datos: DemoVisor
-- ============================================================

-- ============================================================
-- Tabla de log de consultas de PDFs
-- Registra cada vez que un usuario abre un PDF en el visor
-- pdf_nombre: nombre del archivo  (ej. "manual.pdf")
-- pdf_ruta:   ruta fisica completa del archivo en el servidor
-- ============================================================
CREATE TABLE IF NOT EXISTS `tm_log_visor` (
  `log_id`        int(11)      NOT NULL AUTO_INCREMENT,
  `usu_id`        int(11)      NOT NULL,
  `pdf_nombre`    varchar(255) NOT NULL,
  `pdf_ruta`      varchar(500) NOT NULL,
  `fech_consulta` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `fk_log_usuario` (`usu_id`),
  CONSTRAINT `fk_log_usuario` FOREIGN KEY (`usu_id`) REFERENCES `tm_usuario` (`usu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
