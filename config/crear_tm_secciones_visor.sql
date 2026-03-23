CREATE TABLE `tm_secciones_visor` (
  `sec_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_codigo` varchar(2) NOT NULL,
  `sec_nombre` varchar(150) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`sec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `tm_secciones_visor` (`sec_codigo`, `sec_nombre`, `activo`) VALUES
('01', 'Propiedad', 1),
('02', 'Gravamenes y limitaciones', 1),
('03', 'Asociacion Civil', 1),
('04', 'Resoluciones, Contratos y Convenios', 1),
('05', 'Bienes muebles', 1),
('10', 'Gran Propiedad', 1),
('11', 'Peq. Propiedad', 1),
('15', 'Seccion Auxiliar', 1),
('26', 'Actos y Contratos', 1),
('29', 'Duplicado G.P.', 1),
('30', 'Duplicado P.P.', 1),
('38', 'Fraccionamientos', 1),
('40', 'Hipotecas', 1),
('42', 'RAN', 1),
('49', 'Planos', 1),
('51', 'Promesas de Ventas', 1),
('53', 'Rectificaciones', 1),
('58', 'Res. Jud y Adm.', 1),
('61', 'Sentencias', 1),
('62', 'Solares Urbanos', 1),
('63', 'Tercer Auxiliar', 1),
('68', 'Comercio', 1),
('81', 'Varios', 1);
