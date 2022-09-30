<?php
require_once 'conexion.php';

class ClsUsuario
{
    function ListarUsuario()
    {
        $sql = 'SELECT u.usuario,u.nombre,u.estado,u.tipousuario FROM usuario u';
        global $cnx;
        return $cnx->query($sql);
    }
    function Validarusuario($usuario)
    {
        $sql = 'SELECT * FROM usuario WHERE usuario=:usuario AND pass=:pass AND estado=:estado';
        global $cnx;
        $parametros = [
            ':usuario' => $usuario['user'],
            ':pass' => $usuario['pass'],
            ':estado' => 'A',
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function CambioPass($DatosUsuario)
    {
        $sql = 'UPDATE usuario SET pass=:pass WHERE usuario=:usuario';
        global $cnx;
        $parametros = [
            ':pass' => $DatosUsuario['pass'],
            ':usuario' => $DatosUsuario['usuario'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarUsuario($DatosUsuario)
    {
        $sql = 'INSERT INTO usuario(usuario, pass, nombre, tipousuario, idregion, estado) VALUES (:usuario, :pass, :nombre, :tipousuario, :idregion, :estado)';
        global $cnx;
        $parametros = [
            ':usuario' => $DatosUsuario['usuario'],
            ':pass' => md5($DatosUsuario['pass']),
            ':nombre' => $DatosUsuario['nombre'],
            ':tipousuario' => $DatosUsuario['tipousuario'],
            ':idregion' => $DatosUsuario['idregion'],
            ':estado' => 'A',
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarUsuario($DatosUsuario)
    {
        $sql = 'UPDATE usuario SET tipousuario=:tipousuario,idregion=:idregion WHERE usuario=:usuario';
        global $cnx;
        $parametros = [
            ':usuario' => $DatosUsuario['usuario'],
            ':tipousuario' => $DatosUsuario['tipousuario'],
            ':idregion' => $DatosUsuario['idregion'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function CambiarEstado($usuario, $estado)
    {
        $sql = 'UPDATE usuario SET estado=:estado WHERE usuario=:usuario';
        global $cnx;
        $parametros = [
            ':usuario' => $usuario,
            ':estado' => $estado,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function FiltrarUsuario($filtro)
    {
        $sql = 'SELECT u.usuario,u.nombre,u.estado,u.tipousuario FROM usuario u WHERE u.nombre LIKE :nombre';
        global $cnx;
        $parametros = [
            ':nombre' => '%' . $filtro . '%',
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function BuscararUsuario($usuario)
    {
        $sql = 'SELECT u.usuario,u.nombre,u.estado,u.tipousuario FROM usuario u WHERE u.usuario=:usuario';
        global $cnx;
        $parametros = [
            ':usuario' => $usuario,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ExtraeRegion($usuario)
    {
        $sql = 'SELECT r.region,r.idregion FROM usuario u INNER JOIN region r ON r.idregion=u.idregion WHERE u.usuario=:usuario';
        global $cnx;
        $parametros = [
            ':usuario' => $usuario,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    //SELECT r.region,r.idregion FROM usuario u INNER JOIN region r ON r.idregion=u.idregion WHERE u.usuario='12345678'
}
