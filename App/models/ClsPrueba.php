<?php
require_once 'conexion.php';

class ClsPruebas
{
    function ListarIpress()
    {
        $sql = 'SELECT * FROM ipress';
        global $cnx;
        return $cnx->query($sql);
    }
    function BuscarIPress_Nombre($NombreIpress)
    {
        $sql = 'SELECT * FROM ipress WHERE ipress=:ipress';
        global $cnx;
        $parametros = [
            ':ipress' => $NombreIpress
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ListarRegiones()
    {
        $sql = 'SELECT r.idregion, r.region, COUNT(i.codigoipress) as cantidadIpress FROM region r INNER JOIN ipress i ON i.idregion=r.idregion GROUP BY r.idregion';
        global $cnx;
        return $cnx->query($sql);
    }
    function IpressPorRegion($idregion)
    {
        $sql = 'SELECT * FROM ipress WHERE idregion=:idregion';
        global $cnx;
        $parametros = [
            ':idregion' => $idregion
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ListarIpressRegistrosHoy($fecha, $virus)
    {
        $sql = 'SELECT rd.idreporte,i.codigoipress,i.ipress,rd.comentario,u.nombre,rd.fecharegistro FROM reportediario rd INNER JOIN ipress i ON i.codigoipress= rd.codigoipress INNER JOIN usuario u ON rd.idusuario = u.usuario WHERE rd.fecha=:fecha AND rd.virus=:virus';
        global $cnx;
        $parametros = [
            ':fecha' => $fecha,
            ':virus' => $virus
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ListarIpressxMacroRegistrosHoy($fecha, $idregion, $virus)
    {
        $sql = 'SELECT rd.idreporte,i.codigoipress,i.ipress,rd.comentario,u.nombre,rd.fecharegistro FROM reportediario rd INNER JOIN ipress i ON i.codigoipress= rd.codigoipress INNER JOIN usuario u ON rd.idusuario = u.usuario WHERE rd.fecha=:fecha AND i.idregion=:idregion AND rd.virus=:virus';
        global $cnx;
        $parametros = [
            ':fecha' => $fecha,
            ':idregion' => $idregion,
            ':virus' => $virus
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function CantidadPorPrueba($idreporte, $tipo)
    {
        $sql = 'SELECT c_pcr,c_ant,c_ser FROM detallepruebas WHERE idreporte=:idreporte AND tipo_beneficiario=:tipo_beneficiario';
        global $cnx;
        $parametros = [
            ':idreporte' => $idreporte,
            ':tipo_beneficiario' => $tipo
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function RegistrarReporte($DatosReporte)
    {
        $sql = 'INSERT INTO reportediario(codigoipress, fecha, comentario,idusuario,fecharegistro,virus) VALUES (:codigoipress, :fecha, :comentario,:idusuario,:fecharegistro,:virus)';
        global $cnx;
        $parametros = [
            ':codigoipress' => $DatosReporte['codigoipress'],
            ':fecha' => $DatosReporte['fecha'],
            ':comentario' => $DatosReporte['comentario'],
            ':idusuario' => $DatosReporte['idusuario'],
            ':fecharegistro' => $DatosReporte['fecharegistro'],
            ':virus' => $DatosReporte['virus'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        if ($pre->execute($parametros)) {
            return $cnx->lastInsertId();
        } else {
            return '0';
        }
    }
    function RegistrarDetallePruebas($DatosDetalle)
    {
        $sql = 'INSERT INTO detallepruebas(idreporte,tipo_beneficiario,c_pcr,c_ant,c_ser) VALUES (:idreporte,:tipo_beneficiario,:c_pcr,:c_ant,:c_ser)';
        global $cnx;
        $parametros = [
            ':idreporte' => $DatosDetalle['idreporte'],
            ':tipo_beneficiario' => $DatosDetalle['tipo_beneficiario'],
            ':c_pcr' => $DatosDetalle['c_pcr'],
            ':c_ant' => $DatosDetalle['c_ant'],
            ':c_ser' => $DatosDetalle['c_ser'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function BuscarRegistradoHoy($fecha, $ipress, $virus)
    {
        $sql = 'SELECT * FROM reportediario WHERE codigoipress=:codigoipress AND fecha=:fecha AND virus=:virus';
        global $cnx;
        $parametros = [
            ':codigoipress' => $ipress,
            ':fecha' => $fecha,
            ':virus' => $virus,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ReporteMensual($idtipoprueba, $codigoipress, $fecha)
    {
        $sql = 'SELECT dp.cantidad
        FROM detallepruebas dp INNER JOIN reportediario rd ON dp.idreporte=rd.idreporte
        WHERE dp.idtipoprueba=:idtipoprueba AND rd.codigoipress=:codigoipress AND rd.fecha=:fecha';
        global $cnx;
        $parametros = [
            ':idtipoprueba' => $idtipoprueba,
            ':codigoipress' => $codigoipress,
            ':fecha' => $fecha,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function EliminarPruebas($idreporte)
    {
        $sql = 'DELETE FROM detallepruebas WHERE idreporte = :idreporte';
        global $cnx;
        $parametros = [
            ':idreporte' => $idreporte,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function EliminarReporte($idreporte)
    {
        $sql = 'DELETE FROM reportediario WHERE idreporte = :idreporte';
        global $cnx;
        $parametros = [
            ':idreporte' => $idreporte,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function EditarReporte($DatosReporte)
    {
        $sql = 'UPDATE reportediario SET comentario=:comentario, idusuario=:idusuario WHERE idreporte = :idreporte';
        global $cnx;
        $parametros = [
            ':idreporte' => $DatosReporte['idreporte'],
            ':comentario' => $DatosReporte['comentario'],
            ':idusuario' => $DatosReporte['idusuario'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function TotalxDia($fecha, $idtipoprueba)
    {
        $sql = 'SELECT SUM(dp.cantidad) as total FROM detallepruebas dp INNER JOIN reportediario rd ON dp.idreporte=rd.idreporte WHERE rd.fecha=:fecha AND dp.idtipoprueba=:idtipoprueba';
        global $cnx;
        $parametros = [
            ':fecha' => $fecha,
            ':idtipoprueba' => $idtipoprueba,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    //BuscarReportes
    function ReportesxMes($mes, $idipress, $virus)
    {
        $sql = 'SELECT idreporte,DAY(fecha) as dia,fecha FROM reportediario WHERE MONTH(fecha)=:mes AND codigoipress=:codigoipress AND virus=:virus';
        global $cnx;
        $parametros = [
            ':mes' => $mes,
            ':codigoipress' => $idipress,
            ':virus' => $virus
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function DetallePruebasxReporte($idreporte, $tipo_beneficiario)
    {
        $sql = 'SELECT * FROM detallepruebas WHERE idreporte=:idreporte AND tipo_beneficiario=:tipo_beneficiario';
        global $cnx;
        $parametros = [
            ':idreporte' => $idreporte,
            ':tipo_beneficiario' => $tipo_beneficiario,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function DetallePruebasxReporteGeneral($idreporte)
    {
        $sql = 'SELECT SUM(c_pcr) as c_pcr, SUM(c_ant) as c_ant,SUM(c_ser) as c_ser FROM detallepruebas WHERE idreporte=:idreporte';
        global $cnx;
        $parametros = [
            ':idreporte' => $idreporte,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function DetallePruebasxReporteTitulares($idreporte)
    {
        $sql = 'SELECT SUM(c_pcr) as c_pcr, SUM(c_ant) as c_ant,SUM(c_ser) as c_ser FROM detallepruebas WHERE idreporte=:idreporte AND tipo_beneficiario<>:tipo_beneficiario';
        global $cnx;
        $parametros = [
            ':idreporte' => $idreporte,
            ':tipo_beneficiario' => 'F',
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function BuscarReporte($idreporte)
    {
        $sql = 'SELECT rd.fecha,rd.fecharegistro,rd.comentario,ip.ipress,ip.codigoipress,rd.virus
        FROM reportediario rd INNER JOIN ipress ip ON ip.codigoipress=rd.codigoipress 
        WHERE idreporte=:idreporte';
        global $cnx;
        $parametros = [
            ':idreporte' => $idreporte,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function BuscarDetalleReporte($idreporte)
    {
        $sql = 'SELECT * FROM detallepruebas WHERE idreporte=:idreporte';
        global $cnx;
        $parametros = [
            ':idreporte' => $idreporte,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
/*SELECT rd.fecha,rd.fecharegistro,rd.comentario,ip.ipress
FROM reportediario rd INNER JOIN ipress ip ON ip.codigoipress=rd.codigoipress 
WHERE idreporte=23

SELECT * FROM detallepruebas WHERE idreporte=23
*/