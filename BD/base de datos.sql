SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `scipgi` DEFAULT CHARACTER SET utf8 ;
USE `scipgi` ;

-- -----------------------------------------------------
-- Table `scipgi`.`cat_departamento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`cat_departamento` (
  `pk_departamento` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `departamento` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`pk_departamento`) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`cat_empleado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`cat_empleado` (
  `pk_empleado` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre_empleado` VARCHAR(50) NOT NULL ,
  `fk_depto` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`pk_empleado`) ,
  INDEX `fk_departamento_idx` (`fk_depto` ASC) ,
  CONSTRAINT `fk_departamento`
    FOREIGN KEY (`fk_depto` )
    REFERENCES `scipgi`.`cat_departamento` (`pk_departamento` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`asignacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`asignacion` (
  `pk_asigancion` INT(11) NOT NULL AUTO_INCREMENT ,
  `fk_departamento` INT(10) UNSIGNED NOT NULL ,
  `codigoAsignacion` BIGINT(19) UNSIGNED NOT NULL ,
  `cantidadEquipos` INT(10) UNSIGNED NOT NULL ,
  `fk_empleadoAsignado` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`pk_asigancion`) ,
  UNIQUE INDEX `codigoAsignacion_UNIQUE` (`codigoAsignacion` ASC) ,
  INDEX `fk_asignacion_cat_departamento1_idx` (`fk_departamento` ASC) ,
  INDEX `fk_asignacion_cat_empleado1_idx` (`fk_empleadoAsignado` ASC) ,
  CONSTRAINT `fk_asignacion_cat_departamento1`
    FOREIGN KEY (`fk_departamento` )
    REFERENCES `scipgi`.`cat_departamento` (`pk_departamento` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_asignacion_cat_empleado1`
    FOREIGN KEY (`fk_empleadoAsignado` )
    REFERENCES `scipgi`.`cat_empleado` (`pk_empleado` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`cat_autoriza`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`cat_autoriza` (
  `pk_autoriza` INT(11) NOT NULL AUTO_INCREMENT ,
  `autoriza` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`pk_autoriza`) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `scipgi`.`cat_estado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`cat_estado` (
  `pk_estado` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `estado` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`pk_estado`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`cat_categoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`cat_categoria` (
  `pk_categoria` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `categoria` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`pk_categoria`) ,
  UNIQUE INDEX `categoria_UNIQUE` (`categoria` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`cat_marca`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`cat_marca` (
  `pk_marca` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `marca` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`pk_marca`) ,
  UNIQUE INDEX `marca_UNIQUE` (`marca` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`catConsumible`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`catConsumible` (
  `pkConsumible` INT NOT NULL AUTO_INCREMENT ,
  `estadoConsumible` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`pkConsumible`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scipgi`.`invgeneral`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`invgeneral` (
  `pk_inventario` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `fk_marca` INT(10) UNSIGNED NOT NULL ,
  `modelo` VARCHAR(50) NULL DEFAULT NULL ,
  `detalle` VARCHAR(255) NULL DEFAULT NULL ,
  `cantidad` INT(10) UNSIGNED NOT NULL ,
  `fk_categoria` INT(10) UNSIGNED NOT NULL ,
  `codigoBarra` BIGINT(19) UNSIGNED NOT NULL ,
  `fkConsumible` INT NOT NULL ,
  `tipoInventario` VARCHAR(70) NOT NULL ,
  PRIMARY KEY (`pk_inventario`) ,
  INDEX `fk_marca_idx` (`fk_marca` ASC) ,
  INDEX `fk_invgeneral_cat_categoria1_idx` (`fk_categoria` ASC) ,
  INDEX `fk_invgeneral_catConsumibe1_idx` (`fkConsumible` ASC) ,
  CONSTRAINT `fk_invgeneral_cat_categoria1`
    FOREIGN KEY (`fk_categoria` )
    REFERENCES `scipgi`.`cat_categoria` (`pk_categoria` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_marcas`
    FOREIGN KEY (`fk_marca` )
    REFERENCES `scipgi`.`cat_marca` (`pk_marca` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_invgeneral_catConsumibe1`
    FOREIGN KEY (`fkConsumible` )
    REFERENCES `scipgi`.`catConsumible` (`pkConsumible` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`cat_cargo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`cat_cargo` (
  `pk_cargo` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `cargo` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`pk_cargo`) ,
  UNIQUE INDEX `cargo_UNIQUE` (`cargo` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`cat_tipousuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`cat_tipousuario` (
  `pk_tipoUsuario` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `tipo` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`pk_tipoUsuario`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`usuario` (
  `pk_usuarios` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nom_usuario` VARCHAR(100) NOT NULL ,
  `ap_patusuario` VARCHAR(100) NOT NULL ,
  `ap_matusuario` VARCHAR(100) NOT NULL ,
  `fk_cargo` INT(10) UNSIGNED NOT NULL ,
  `telefono` BIGINT(19) UNSIGNED NOT NULL ,
  `correo` VARCHAR(50) NOT NULL ,
  `fecha_alta` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `nickname` VARCHAR(45) NOT NULL ,
  `pass` VARCHAR(255) NOT NULL ,
  `fk_tipoUsuario` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`pk_usuarios`) ,
  UNIQUE INDEX `nickname_UNIQUE` (`nickname` ASC) ,
  INDEX `fk_cargo_idx` (`fk_cargo` ASC) ,
  INDEX `fk_usuario_cat_tipoUsuario1_idx` (`fk_tipoUsuario` ASC) ,
  CONSTRAINT `fk_cargo`
    FOREIGN KEY (`fk_cargo` )
    REFERENCES `scipgi`.`cat_cargo` (`pk_cargo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_cat_tipoUsuario1`
    FOREIGN KEY (`fk_tipoUsuario` )
    REFERENCES `scipgi`.`cat_tipousuario` (`pk_tipoUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`invdetalle`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`invdetalle` (
  `pk_invDetalle` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `codigoBarra` BIGINT(19) UNSIGNED NOT NULL ,
  `fk_inventario` INT(10) UNSIGNED NOT NULL ,
  `no_Serie` VARCHAR(50) NULL DEFAULT NULL ,
  `fk_estado` INT(10) UNSIGNED NOT NULL ,
  `fk_usuario` INT(10) UNSIGNED NOT NULL ,
  `fecha_alta` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`pk_invDetalle`) ,
  INDEX `fk_inventario_idx` (`fk_inventario` ASC) ,
  INDEX `fk_estado_idx` (`fk_estado` ASC) ,
  INDEX `fk_usuario_idx` (`fk_usuario` ASC) ,
  CONSTRAINT `fk_estado`
    FOREIGN KEY (`fk_estado` )
    REFERENCES `scipgi`.`cat_estado` (`pk_estado` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inventario`
    FOREIGN KEY (`fk_inventario` )
    REFERENCES `scipgi`.`invgeneral` (`pk_inventario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario`
    FOREIGN KEY (`fk_usuario` )
    REFERENCES `scipgi`.`usuario` (`pk_usuarios` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 22
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`baja`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`baja` (
  `pk_baja` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `fk_usuarios` INT(10) UNSIGNED NOT NULL ,
  `fk_invD` INT(10) UNSIGNED NOT NULL ,
  `fk_autoriza` INT(11) NOT NULL ,
  `motivo` VARCHAR(255) NOT NULL ,
  `fecha_baja` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`pk_baja`) ,
  INDEX `fk_baja_usuario1_idx` (`fk_usuarios` ASC) ,
  INDEX `fk_baja_invDetalle1_idx` (`fk_invD` ASC) ,
  INDEX `fk_autoriza_idx` (`fk_autoriza` ASC) ,
  CONSTRAINT `fk_autoriza`
    FOREIGN KEY (`fk_autoriza` )
    REFERENCES `scipgi`.`cat_autoriza` (`pk_autoriza` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_baja_invDetalle1`
    FOREIGN KEY (`fk_invD` )
    REFERENCES `scipgi`.`invdetalle` (`pk_invDetalle` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_baja_usuario1`
    FOREIGN KEY (`fk_usuarios` )
    REFERENCES `scipgi`.`usuario` (`pk_usuarios` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `scipgi`.`categoriasoftware`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`categoriasoftware` (
  `pk_categoriaSoftware` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `categoriaSoftware` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`pk_categoriaSoftware`) ,
  UNIQUE INDEX `categoriaSoftware_UNIQUE` (`categoriaSoftware` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `scipgi`.`cat_ubicaciones`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`cat_ubicaciones` (
  `pk_ubicacion` INT NOT NULL AUTO_INCREMENT ,
  `ubicacion` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`pk_ubicacion`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scipgi`.`equiposasignados`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`equiposasignados` (
  `pk_equiposAsignados` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `fk_invDetalle` INT(11) UNSIGNED NOT NULL ,
  `fk_asigancion` INT(11) NOT NULL ,
  `fecha_asignacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `fk_ubicacion` INT NOT NULL ,
  `fk_usuarioAsigno` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`pk_equiposAsignados`) ,
  UNIQUE INDEX `fk_invDetalle_UNIQUE` (`fk_invDetalle` ASC) ,
  INDEX `fk_equiposAsignados_invdetalle1_idx` (`fk_invDetalle` ASC) ,
  INDEX `fk_equiposAsignados_asignacion1_idx` (`fk_asigancion` ASC) ,
  INDEX `fk_equiposasignados_cat_ubicaciones1_idx` (`fk_ubicacion` ASC) ,
  INDEX `fk_equiposasignados_usuario1_idx` (`fk_usuarioAsigno` ASC) ,
  CONSTRAINT `fk_equiposAsignados_asignacion1`
    FOREIGN KEY (`fk_asigancion` )
    REFERENCES `scipgi`.`asignacion` (`pk_asigancion` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equiposAsignados_invdetalle1`
    FOREIGN KEY (`fk_invDetalle` )
    REFERENCES `scipgi`.`invdetalle` (`pk_invDetalle` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equiposasignados_cat_ubicaciones1`
    FOREIGN KEY (`fk_ubicacion` )
    REFERENCES `scipgi`.`cat_ubicaciones` (`pk_ubicacion` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equiposasignados_usuario1`
    FOREIGN KEY (`fk_usuarioAsigno` )
    REFERENCES `scipgi`.`usuario` (`pk_usuarios` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 63
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `scipgi`.`software`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`software` (
  `pk_software` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombreSoftware` VARCHAR(100) NOT NULL ,
  `fk_categoriaSoftware` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`pk_software`) ,
  UNIQUE INDEX `nombreSoftware_UNIQUE` (`nombreSoftware` ASC) ,
  INDEX `fk_listaSoftware_categoriaSoftware1_idx` (`fk_categoriaSoftware` ASC) ,
  CONSTRAINT `fk_listaSoftware_categoriaSoftware1`
    FOREIGN KEY (`fk_categoriaSoftware` )
    REFERENCES `scipgi`.`categoriasoftware` (`pk_categoriaSoftware` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `scipgi`.`softwareasignado`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`softwareasignado` (
  `pk_softwareAsignado` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `fk_equiposAsignados` INT(10) UNSIGNED NOT NULL ,
  `fk_software` INT(10) UNSIGNED NOT NULL ,
  `serialActivacion` VARCHAR(255) NULL DEFAULT NULL ,
  `fechaInstalacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`pk_softwareAsignado`) ,
  INDEX `fk_softwareAsignado_equiposasignados1_idx` (`fk_equiposAsignados` ASC) ,
  INDEX `fk_softwareAsignado_Software1_idx` (`fk_software` ASC) ,
  CONSTRAINT `fk_softwareAsignado_equiposasignados1`
    FOREIGN KEY (`fk_equiposAsignados` )
    REFERENCES `scipgi`.`equiposasignados` (`pk_equiposAsignados` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_softwareAsignado_Software1`
    FOREIGN KEY (`fk_software` )
    REFERENCES `scipgi`.`software` (`pk_software` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 31
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `scipgi`.`ultimonumcodigo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`ultimonumcodigo` (
  `pk_ultimoNo` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ultimoNum` INT(10) UNSIGNED NOT NULL ,
  `fk_invG` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`pk_ultimoNo`) ,
  INDEX `fk_ultimoNumCodigo_invgeneral1_idx` (`fk_invG` ASC) ,
  CONSTRAINT `fk_ultimoNumCodigo_invgeneral1`
    FOREIGN KEY (`fk_invG` )
    REFERENCES `scipgi`.`invgeneral` (`pk_inventario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `scipgi`.`catProveedor`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`catProveedor` (
  `pkProveedor` INT NOT NULL AUTO_INCREMENT ,
  `nombreProveedor` VARCHAR(150) NOT NULL ,
  `rfc` VARCHAR(20) NOT NULL ,
  `direccion` VARCHAR(150) NOT NULL ,
  `telefono` BIGINT NOT NULL ,
  PRIMARY KEY (`pkProveedor`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scipgi`.`catEstadoSaliente`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`catEstadoSaliente` (
  `pkEstadoSaliente` INT NOT NULL AUTO_INCREMENT ,
  `EstadoSaliente` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`pkEstadoSaliente`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scipgi`.`catPartida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`catPartida` (
  `pkPartida` INT NOT NULL AUTO_INCREMENT ,
  `numeroPartida` INT UNSIGNED NOT NULL ,
  `descripcionPartida` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`pkPartida`) ,
  UNIQUE INDEX `numeroPartida_UNIQUE` (`numeroPartida` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scipgi`.`factura`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`factura` (
  `pkFactura` INT NOT NULL AUTO_INCREMENT ,
  `fk_usuariosFactura` INT(10) UNSIGNED NOT NULL ,
  `serie` VARCHAR(50) NULL ,
  `folio` VARCHAR(50) NULL ,
  `fechaYhora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `fkProveedor` INT NOT NULL ,
  `subtotal` VARCHAR(50) NOT NULL ,
  `total` VARCHAR(50) NOT NULL ,
  `fkEstadoSaliente` INT NOT NULL ,
  `fechaFac` DATE NOT NULL ,
  `proyecto` VARCHAR(100) NULL ,
  `fkPartida` INT NULL ,
  `tipo` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`pkFactura`) ,
  INDEX `fk_factura_usuario1_idx` (`fk_usuariosFactura` ASC) ,
  INDEX `fk_factura_catProveedor1_idx` (`fkProveedor` ASC) ,
  INDEX `fk_factura_catEstadoSaliente1_idx` (`fkEstadoSaliente` ASC) ,
  INDEX `fk_factura_catPartida1_idx` (`fkPartida` ASC) ,
  CONSTRAINT `fk_factura_usuario1`
    FOREIGN KEY (`fk_usuariosFactura` )
    REFERENCES `scipgi`.`usuario` (`pk_usuarios` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_factura_catProveedor1`
    FOREIGN KEY (`fkProveedor` )
    REFERENCES `scipgi`.`catProveedor` (`pkProveedor` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_factura_catEstadoSaliente1`
    FOREIGN KEY (`fkEstadoSaliente` )
    REFERENCES `scipgi`.`catEstadoSaliente` (`pkEstadoSaliente` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_factura_catPartida1`
    FOREIGN KEY (`fkPartida` )
    REFERENCES `scipgi`.`catPartida` (`pkPartida` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scipgi`.`catEstadoInventario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`catEstadoInventario` (
  `pkEstadoInventario` INT NOT NULL AUTO_INCREMENT ,
  `EstadoInventario` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`pkEstadoInventario`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scipgi`.`detalleFactura`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`detalleFactura` (
  `pkDetalleFactura` INT NOT NULL AUTO_INCREMENT ,
  `fkFactura` INT NOT NULL ,
  `cantidad` INT NOT NULL ,
  `unidad` VARCHAR(50) NOT NULL ,
  `descripcion` VARCHAR(255) NOT NULL ,
  `precioUnitario` VARCHAR(50) NOT NULL ,
  `iva` VARCHAR(50) NOT NULL ,
  `importe` VARCHAR(50) NOT NULL ,
  `masIva` VARCHAR(50) NOT NULL ,
  `fkEstadoInventario` INT NOT NULL ,
  PRIMARY KEY (`pkDetalleFactura`) ,
  INDEX `fk_detalleFactura_factura1_idx` (`fkFactura` ASC) ,
  INDEX `fk_detalleFactura_catEstadoInventario1_idx` (`fkEstadoInventario` ASC) ,
  CONSTRAINT `fk_detalleFactura_factura1`
    FOREIGN KEY (`fkFactura` )
    REFERENCES `scipgi`.`factura` (`pkFactura` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalleFactura_catEstadoInventario1`
    FOREIGN KEY (`fkEstadoInventario` )
    REFERENCES `scipgi`.`catEstadoInventario` (`pkEstadoInventario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scipgi`.`Saliente`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `scipgi`.`Saliente` (
  `pkFacturaSaliente` INT NOT NULL AUTO_INCREMENT ,
  `clave` VARCHAR(50) NOT NULL ,
  `importe` VARCHAR(45) NOT NULL ,
  `factura_pkFactura` INT NOT NULL ,
  PRIMARY KEY (`pkFacturaSaliente`) ,
  INDEX `fk_Saliente_factura1_idx` (`factura_pkFactura` ASC) ,
  CONSTRAINT `fk_Saliente_factura1`
    FOREIGN KEY (`factura_pkFactura` )
    REFERENCES `scipgi`.`factura` (`pkFactura` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `scipgi` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `scipgi`.`cat_estado`
-- -----------------------------------------------------
START TRANSACTION;
USE `scipgi`;
INSERT INTO `scipgi`.`cat_estado` (`pk_estado`, `estado`) VALUES (1, 'DISPONIBLE');
INSERT INTO `scipgi`.`cat_estado` (`pk_estado`, `estado`) VALUES (2, 'ASIGNADO');
INSERT INTO `scipgi`.`cat_estado` (`pk_estado`, `estado`) VALUES (3, 'MANTENIMIENTO');
INSERT INTO `scipgi`.`cat_estado` (`pk_estado`, `estado`) VALUES (4, 'BAJA');
INSERT INTO `scipgi`.`cat_estado` (`pk_estado`, `estado`) VALUES (5, 'BAJA CONSUMIBLE');

COMMIT;

-- -----------------------------------------------------
-- Data for table `scipgi`.`catConsumible`
-- -----------------------------------------------------
START TRANSACTION;
USE `scipgi`;
INSERT INTO `scipgi`.`catConsumible` (`pkConsumible`, `estadoConsumible`) VALUES (1, 'NO');
INSERT INTO `scipgi`.`catConsumible` (`pkConsumible`, `estadoConsumible`) VALUES (2, 'SI');

COMMIT;

-- -----------------------------------------------------
-- Data for table `scipgi`.`cat_cargo`
-- -----------------------------------------------------
START TRANSACTION;
USE `scipgi`;
INSERT INTO `scipgi`.`cat_cargo` (`pk_cargo`, `cargo`) VALUES (1, 'admin');

COMMIT;

-- -----------------------------------------------------
-- Data for table `scipgi`.`cat_tipousuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `scipgi`;
INSERT INTO `scipgi`.`cat_tipousuario` (`pk_tipoUsuario`, `tipo`) VALUES (1, 'admin');
INSERT INTO `scipgi`.`cat_tipousuario` (`pk_tipoUsuario`, `tipo`) VALUES (2, 'MATERIALES');
INSERT INTO `scipgi`.`cat_tipousuario` (`pk_tipoUsuario`, `tipo`) VALUES (3, 'INVENTARIOS');
INSERT INTO `scipgi`.`cat_tipousuario` (`pk_tipoUsuario`, `tipo`) VALUES (4, 'FINANCIEROS');

COMMIT;

-- -----------------------------------------------------
-- Data for table `scipgi`.`usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `scipgi`;
INSERT INTO `scipgi`.`usuario` (`pk_usuarios`, `nom_usuario`, `ap_patusuario`, `ap_matusuario`, `fk_cargo`, `telefono`, `correo`, `fecha_alta`, `nickname`, `pass`, `fk_tipoUsuario`) VALUES (1, 'admin', 'admin', 'admin', 1, 123, 'admin@admin', '2014-01-24 12:29:16', 'admin', '550ca418a1ca0898f8efdd5a5524a26b9e2cb860c62d29c270da8ba6cba3f8ec4239283be0fb87f3ab038983cf4deafb9dd42aa11e37a9e11818f6d55fa4c197453375', 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `scipgi`.`catProveedor`
-- -----------------------------------------------------
START TRANSACTION;
USE `scipgi`;
INSERT INTO `scipgi`.`catProveedor` (`pkProveedor`, `nombreProveedor`, `rfc`, `direccion`, `telefono`) VALUES (1, 'compucopias', 'MIRFC', 'LA DE SIMPRE', 101010);

COMMIT;

-- -----------------------------------------------------
-- Data for table `scipgi`.`catEstadoSaliente`
-- -----------------------------------------------------
START TRANSACTION;
USE `scipgi`;
INSERT INTO `scipgi`.`catEstadoSaliente` (`pkEstadoSaliente`, `EstadoSaliente`) VALUES (1, '0');
INSERT INTO `scipgi`.`catEstadoSaliente` (`pkEstadoSaliente`, `EstadoSaliente`) VALUES (2, '1');

COMMIT;

-- -----------------------------------------------------
-- Data for table `scipgi`.`catPartida`
-- -----------------------------------------------------
START TRANSACTION;
USE `scipgi`;
INSERT INTO `scipgi`.`catPartida` (`pkPartida`, `numeroPartida`, `descripcionPartida`) VALUES (1, 234, 'esta es la partida 234');
INSERT INTO `scipgi`.`catPartida` (`pkPartida`, `numeroPartida`, `descripcionPartida`) VALUES (NULL, 456, 'esta es la partida 456');

COMMIT;

-- -----------------------------------------------------
-- Data for table `scipgi`.`catEstadoInventario`
-- -----------------------------------------------------
START TRANSACTION;
USE `scipgi`;
INSERT INTO `scipgi`.`catEstadoInventario` (`pkEstadoInventario`, `EstadoInventario`) VALUES (1, '0');
INSERT INTO `scipgi`.`catEstadoInventario` (`pkEstadoInventario`, `EstadoInventario`) VALUES (2, '1');

COMMIT;
