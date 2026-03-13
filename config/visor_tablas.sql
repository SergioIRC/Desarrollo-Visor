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

-- ============================================================
-- Tabla de municipios para el filtro del Visor de PDFs
-- mun_codigo: número que se envía como parámetro de búsqueda
-- activo:     1 = visible en el select, 0 = oculto sin borrar
-- ============================================================
CREATE TABLE IF NOT EXISTS `tm_municipios_visor` (
  `mun_id`     int(11)      NOT NULL AUTO_INCREMENT,
  `mun_nombre` varchar(100) NOT NULL,
  `mun_codigo` int(11)      NOT NULL,
  `activo`     tinyint(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (`mun_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tm_municipios_visor` (`mun_nombre`, `mun_codigo`, `activo`) VALUES
('Allende',        13, 1),
('General Teran',  34, 1),
('Montemorelos',   45, 1),
('Marin',          46, 1),
('Rayones',        53, 1);
