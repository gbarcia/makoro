<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
/**
 * Description of controladorVueloBDclass
 * Clase para manejar los vuelos en la base de datos
 * @author Diana Uribe
 */
class controladorVueloBDclass {
    public $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    /**
     * Metodo para agregar un nuevo vuelo en la base de datos
     * @param <VUELO> $vuelo El vuelo a insertar en la base de datos
     * @return <boolean> El resultado de la operacion
     */
    function agregarNuevoVuelo($vuelo) {
        $resultado = false;
        $query = "INSERT INTO VUELO (fecha,hora,AVION_matricula,RUTA_sitioSalida,RUTA_sitioLlegada)
                  VALUES ('".$vuelo->getFecha()."',
                          '".$vuelo->getHora()."',";
        if ($vuelo->getAvionMatricula() == NULL)
        $query .= "NULL,";
        else
        $query .= "'".$vuelo->getAvionMatricula()."',";
        $query .= "'".$vuelo->getRutaSitioSalida()."',
                          '".$vuelo->getRutaSitioLlegada()."')";
        $resultado = $this->transaccion->realizarTransaccionInsertId($query);
        return $resultado;
    }

    /**
     * Metodo para modificar cualquier dato del vuelo
     * @param <VUELO> $vuelo
     * @return <boolean>
     */
    function editarVuelo($vuelo) {
        $resultado = false;
        $query = "UPDATE VUELO v SET v.fecha = '".$vuelo->getFecha()."',
                                     v.hora = '".$vuelo->getHora()."',
                                     v.AVION_matricula = '".$vuelo->getAvionMatricula()."',
                                     v.RUTA_sitioSalida = '".$vuelo->getRutaSitioSalida()."',
                                     v.RUTA_sitioLlegada = '".$vuelo->getRutaSitioLlegada()."',
                                     v.cantidadInfantes = ".$vuelo->getCantidadinfantes()."
                  WHERE v.id = ".$vuelo->getId()."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para actualizar la cantidad de infantes en un vuelo
     * @param <type> $vuelo El vuelo a editar
     * @return <type> El resultado de la operacion 
     */
    function actualizarCantidadInfantesVuelo($idVuelo, $cantidadNueva) {
        $resultado = false;
        $query = "UPDATE VUELO v SET v.cantidadInfantes = ".$cantidadNueva."
                  WHERE v.id = ".$idVuelo."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar uno o varios vuelos, dependiendo del filtro. Los datos
     * proporcionados pueden ser: por rango de fechas, hora, matricula del avion,
     * rutas, cedula o pasaporte, nombre o apellido del pasajero, nombre o apellido
     * del cliente que hizo la reserva, solicitud y por el estado de la reserva
     * @param <Date> $fechaInicio Fecha inicio del vuelo a consultar
     * @param <Date> $fechaFin Fecha fin del vuelo a consultar
     * @param <Time> $hora Hora del vuelo a consultar
     * @param <String> $avionMatricula Matricula del avion a consultar
     * @param <String> $rutaSitioSalida Ruta de ida
     * @param <String> $rutaSitioLlegada Ruta de vuelta
     * @param <Integer> $cantidadAdultosNinos Cantidad de adultos más cantidad de ninos a viajar
     * @param <Integer> $cantidadInfantes Cantidad de infantes a viajar
     * @param <String> $cedulaPasaporte Cedula o pasaporte del pasajero
     * @param <String> $nombrePasajero Nombre del pasajero
     * @param <String> $apellidoPasajero Apellido del pasajero
     * @param <Integer> $cedulaPart Cedula del cliente particular
     * @param <String> $nombrePart Nombre del cliente particular
     * @param <String> $apellidoPart Apellido del cliente particular
     * @param <String> $rifAgencia RIF del cliente agencia
     * @param <String> $nombreAgencia Nombre del cliente agencia
     * @param <String> $solicitud Localizador de la reserva
     * @param <String> $estado Estado de la reserva: PP, PA, CO y CA
     * @return <coleccion> coleccion de vuelos de acuerdo a los datos suministrados
     */
    function consultarVueloConFiltros($fechaInicio,$fechaFin,$hora,$avionMatricula,$rutaSitioSalida,
        $rutaSitioLlegada,$cantidadAdultosNinos,$cantidadInfantes,$cedulaPasaporte,$nombrePasajero,
        $apellidoPasajero,$cedulaPart,$nombrePart,$apellidoPart,
        $rifAgencia,$nombreAgencia,$solicitud,$estado) {
        $resultado = false;
        $query = "SELECT v.id as idVuelo, v.cantidadInfantes as infantes, v.fecha,v.hora,v.AVION_matricula avionMatricula,v.RUTA_sitioSalida rutaSitioSalida,
                         v.RUTA_sitioLlegada rutaSitioLlegada,a.asientos,ru.abreviaturaSalida abreviaturaSalida,
                         ru.abreviaturaLlegada abreviaturaLlegada,
                         IFNULL((SELECT a.asientos-COUNT(vre.RESERVA_id)+v.cantidadInfantes
                                 FROM VUELO_RESERVA vre, VUELO vu , RESERVA re
                                 WHERE re.id = vre.RESERVA_id
                                 AND vu.id = vre.VUELO_id
                                 AND vre.VUELO_id = v.id),0) as quedan,
                         IFNULL((SELECT IF(a.asientos-(COUNT(vre.RESERVA_id))>=".$cantidadAdultosNinos.",TRUE,FALSE)
                                 FROM VUELO_RESERVA vre, VUELO vu, RESERVA re
                                 WHERE re.id = vre.RESERVA_id
                                 AND vu.id = vre.VUELO_id
                                 AND vre.VUELO_id = v.id),0) as disponibilidadAdulto,
                         IFNULL((SELECT 2-vu.cantidadInfantes
                                 FROM VUELO vu
                                 WHERE vu.id = v.id),0) as infantesQuedan
                  FROM VUELO v, RUTA ru, AVION a, RESERVA r ";
        if(($cedulaPasaporte != "") || ($nombrePasajero != "") || ($apellidoPasajero != "")){
            $query .= ", PASAJERO p "; 
        }
        if(($cedulaPart != "") || ($nombrePart != "")  || ($apellidoPart != "")){
            $query.=", CLIENTE_PARTICULAR cp ";
        }
        if(($rifAgencia != "") || ($nombreAgencia != "")){
            $query.=", CLIENTE_AGENCIA ca ";
        }
        if(($cedulaPasaporte != "") || ($nombrePasajero != "") || ($apellidoPasajero != "") ||
            ($cedulaPart != "") || ($nombrePart != "")  || ($apellidoPart != "") ||
            ($rifAgencia != "") || ($nombreAgencia != "") || ($solicitud != "") ||
            ($estado != "")){

            $query.=", VUELO_RESERVA vr ";
        }
        $query.=" WHERE v.RUTA_sitioSalida = ru.sitioSalida
                  AND v.RUTA_sitioLlegada = ru.sitioLlegada ";
        $query .= "AND a.habilitado = 1 ";
        if($hora != "")
        $query.= " AND v.hora = '".$hora."' ";
        if (!(($fechaInicio == "")  && ($fechaFin == ""))){
            if(($fechaInicio != "") && ($fechaFin != "")){
                $query.= " AND v.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."' ";
            }else if($fechaInicio == ""){
                $query.= " AND v.fecha <= '".$fechaFin."' ";
            }else{
                $query.= " AND v.fecha >= '".$fechaInicio."' ";
            }
        }
        if($rutaSitioSalida != "")
        $query.= " AND ru.sitioSalida = '".$rutaSitioSalida."' ";
        if($rutaSitioLlegada != "")
        $query.= " AND ru.sitioLlegada = '".$rutaSitioLlegada."' ";
        if($avionMatricula != "")
        $query.= " AND a.matricula = '".$avionMatricula."' ";
        if($cedulaPasaporte != ""){
            $query.= " AND r.PASAJERO_id = p.id ";
            if(is_numeric($cedulaPasaporte)){
                $query.= " AND p.cedula = ".$cedulaPasaporte."
                           AND vr.VUELO_id = v.id
                           AND r.id = vr.RESERVA_id ";
            }else{
                $query.= " AND p.pasaporte = '".$cedulaPasaporte."'
                           AND vr.VUELO_id = v.id
                           AND r.id = vr.RESERVA_id ";
            }
        }
        if($nombrePasajero != ""){
            $query.= " AND r.PASAJERO_id = p.id
                       AND p.nombre LIKE '".$nombrePasajero."%'
                       AND vr.VUELO_id = v.id
                       AND r.id = vr.RESERVA_id ";
        }
        if($apellidoPasajero != ""){
            $query.= " AND r.PASAJERO_id = p.id
                       AND p.apellido LIKE '".$apellidoPasajero."%'
                       AND vr.VUELO_id = v.id
                       AND r.id = vr.RESERVA_id ";
        }
        if($cedulaPart != ""){
            $query.= " AND r.CLIENTE_PARTICULAR_cedula = cp.cedula
                       AND r.CLIENTE_PARTICULAR_cedula = ".$cedulaPart."
                       AND vr.VUELO_id = v.id
                       AND r.id = vr.RESERVA_id ";
        }
        if($nombrePart != ""){
            $query.= " AND r.CLIENTE_PARTICULAR_cedula = cp.cedula
                       AND cp.nombre LIKE '".$nombrePart."%'
                       AND vr.VUELO_id = v.id
                       AND r.id = vr.RESERVA_id ";
        }
        if($apellidoPart != ""){
            $query.= " AND r.CLIENTE_PARTICULAR_cedula = cp.cedula
                       AND cp.apellido LIKE '".$apellidoPart."%'
                       AND vr.VUELO_id = v.id
                       AND r.id = vr.RESERVA_id ";
        }
        if($rifAgencia != ""){
            $query.= " AND r.CLIENTE_AGENCIA_rif = ca.rif
                       AND r.CLIENTE_AGENCIA_rif = '".$rifAgencia."'
                       AND vr.VUELO_id = v.id
                       AND r.id = vr.RESERVA_id ";
        }
        if($nombreAgencia != ""){
            $query.= " AND r.CLIENTE_AGENCIA_rif = ca.rif
                       AND ca.nombre LIKE '".$nombreAgencia."%'
                       AND vr.VUELO_id = v.id
                       AND r.id = vr.RESERVA_id ";
        }
        if($solicitud != ""){
            $query.= " AND r.solicitud = '".$solicitud."'
                       AND vr.VUELO_id = v.id
                       AND r.id = vr.RESERVA_id ";
        }
        if($estado != ""){
            $query.= " AND r.estado = '".$estado."'
                       AND vr.VUELO_id = v.id
                       AND r.id = vr.RESERVA_id ";
        }
        $query.= " GROUP BY v.id ";
        if($cantidadAdultosNinos != ""){
            $query .= " HAVING disponibilidadAdulto = 1 ";
        }
        $query .= " ORDER BY v.fecha,v.hora ASC
                    LIMIT 50";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar uno o varios vuelos
     * @param <type> $fechaInicio La fecha de inicio a partir de la cual se
     * desea hacer la consulta
     * @param <type> $fechaFin La fecha de fin hasta donde se desea hacer la
     * consulta
     * @return <type> El o los vuelos dentrodel rango de fechas indicados 
     */
    function consultarVueloSinFiltros($fechaInicio,$fechaFin) {
        $resultado = false;
        $query = "SELECT v.id as idVuelo, v.cantidadInfantes as infantes, v.fecha,v.hora,v.AVION_matricula avionMatricula,v.RUTA_sitioSalida rutaSitioSalida,
                         v.RUTA_sitioLlegada rutaSitioLlegada,a.asientos,ru.abreviaturaSalida abreviaturaSalida,
                         ru.abreviaturaLlegada abreviaturaLlegada,
                         IFNULL((SELECT a.asientos-COUNT(vre.RESERVA_id)+v.cantidadInfantes
                                 FROM VUELO_RESERVA vre, VUELO vu , RESERVA re
                                 WHERE re.id = vre.RESERVA_id
                                 AND vu.id = vre.VUELO_id
                                 AND vre.VUELO_id = v.id),0) as quedan,
                         IFNULL((SELECT IF(a.asientos-(COUNT(vre.RESERVA_id)+0)>=0,TRUE,FALSE)
                                 FROM VUELO_RESERVA vre, VUELO vu, RESERVA re
                                 WHERE re.id = vre.RESERVA_id
                                 AND vu.id = vre.VUELO_id
                                 AND vre.VUELO_id = v.id),0) as disponibilidadAdulto,
                         IFNULL((SELECT IF(vu.cantidadInfantes=2,FALSE,TRUE)
                                 FROM VUELO vu
                                 WHERE vu.id = v.id),0) as disponibilidadInfante,
                         IFNULL((SELECT 2-vu.cantidadInfantes
                                 FROM VUELO vu
                                 WHERE vu.id = v.id),0) as infantesQuedan
                  FROM VUELO v, RUTA ru, AVION a, RESERVA r
                  WHERE v.RUTA_sitioSalida = ru.sitioSalida
                  AND v.RUTA_sitioLlegada = ru.sitioLlegada
                  AND a.habilitado = 1 ";
        if (!(($fechaInicio == "")  && ($fechaFin == ""))){
            if(($fechaInicio != "") && ($fechaFin != "")){
                $query.= " AND v.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."' ";
            }else if($fechaInicio == ""){
                $query.= " AND v.fecha <= '".$fechaFin."' ";
            }else{
                $query.= " AND v.fecha >= '".$fechaInicio."' ";
            }
        }
        $query.= " GROUP BY v.id
                   ORDER BY v.fecha,v.hora ASC
                   LIMIT 50";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar la cantidad de asientos reservados
     * @param <Integer> $id Identificador del vuelo a consultar
     * @return <recurso> recurso con el vuelo consultado
     */
    function consultarVueloCantidadReserva($id) {
        $resultado = false;
        $query = "SELECT COUNT(vr.vuelo_id) cantidadReservada, a.asientos asientos, a.matricula
                  FROM VUELO_RESERVA vr, AVION a, VUELO v
                  WHERE vr.VUELO_id IN (SELECT v.id
                                        FROM VUELO v
                                        WHERE v.id = '".$id."')
                  AND vr.VUELO_id = v.id
                  AND v.AVION_matricula = a.matricula";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar los vuelos realizados
     * @return <coleccion> coleccion con los vuelos realizados
     */
    function consultarVuelosRealizados() {
        $resultado = false;
        $query = "SELECT v.id,v.fecha, v.hora, v.AVION_matricula avionMatricula,
                         v.RUTA_sitioSalida sitioSalida, v.RUTA_sitioLlegada sitioLlegada,
                         ru.abreviaturaSalida abreviaturaSalida,ru.abreviaturaLlegada abreviaturaLlegada, a.asientos asientos
                  FROM VUELO v,VUELO_RESERVA vr, RESERVA r, RUTA ru, AVION a
                  WHERE v.fecha < SYSDATE(v.fecha)
                  AND v.id = vr.VUELO_id
                  AND vr.RESERVA_id = r.id
                  AND v.RUTA_sitioSalida = ru.sitioSalida
                  AND v.RUTA_sitioLlegada = ru.sitioLlegada
                  AND v.AVION_matricula = a.matricula
                  GROUP BY v.id,v.fecha, v.hora, v.AVION_matricula, v.RUTA_sitioSalida, v.RUTA_sitioLlegada,ru.abreviaturaSalida,ru.abreviaturaLlegada
                 ORDER BY v.fecha ASC";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar todos los vuelos apartir del dia actual
     * @return <coleccion> coleccion con todo lo vuelos de la base de datos
     */
    function consultarTodosVuelos() {
        $resultado = false;
        $query = "SELECT v.id id,v.fecha,v.hora,
                         v.AVION_matricula avionMatricula,
                         v.RUTA_sitioSalida rutaSitioSalida,
                         v.RUTA_sitioLlegada rutaSitioLlegada,
                         ru.abreviaturaSalida abreviaturaSalida,
                         ru.abreviaturaLlegada abreviaturaLlegada,
                         a.asientos asientos,
                         v.cantidadInfantes cantidadInfantes
                  FROM VUELO v, RUTA ru, AVION a
                  WHERE v.RUTA_sitioSalida = ru.sitioSalida
                  AND v.RUTA_sitioLlegada = ru.sitioLlegada
                  AND v.AVION_matricula = a.matricula
                  AND v.fecha > SYSDATE(v.fecha)
                  AND a.habilitado = 1
                  ORDER BY v.id ASC";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar detalles de un vuelo
     * @param <type> $idVuelo El identificador del vuelo a consultar
     * @param <type> $idSucursal El identificador de la sucursal a consultar
     * @return <type> Los detalles de un vuelo
     */
    function consultarDetallesVuelo($idVuelo){
        $query = "SELECT R.id,R.estado,R.solicitud,IF(R.PASAJERO_id is not null,(SELECT PA.TIPO_PASAJERO_id
                                                 FROM PASAJERO PA
                                                 WHERE PA.id = R.PASAJERO_id),'') as tipoPasajero,
                         IF(R.PASAJERO_id is not null,(SELECT IF(PA.cedula is not null,
                                                        PA.cedula,
                                                        PA.pasaporte)
                                                       FROM PASAJERO PA
                                                       WHERE PA.id = R.PASAJERO_id),'') as cedulaPasaporte,
                         IF(R.PASAJERO_id is not null, (SELECT IF(PA.cedula is not null,
                                                        CONCAT(PA.nombre,' ',PA.apellido),
                                                        CONCAT(PA.nombre,' ',PA.apellido))
                                                        FROM PASAJERO PA
                                                        WHERE PA.id = R.PASAJERO_id),
                                                       IF(R.CLIENTE_AGENCIA_rif is not null,
                                                       CA.nombre, '')) as pasajero,
                         TS.abreviatura as servicio, IF(R.POSADA_id is not null,(SELECT PO.nombrePosada
                                                                            FROM POSADA PO
                                                                            WHERE PO.id = R.POSADA_id),'&nbsp') as posada,
                         E.login as encargadoNombre, S.nombre as sucursal, VR.tipo, IFNULL(R.CLIENTE_AGENCIA_rif,'&nbsp') as agencia,
                         IFNULL(R.CLIENTE_PARTICULAR_cedula,'&nbsp') as particular,
                         IF(R.CLIENTE_AGENCIA_rif is not null,CA.nombre,CONCAT(CP.nombre,' ',CP.apellido)) as clienteNombre,
                         IF(R.PAGO_id is not null,(SELECT IF(PAG.tipo='E','E',PAG.tipo)
                                                   FROM PAGO PAG
                                                   WHERE R.PAGO_id = PAG.id),'&nbsp') as pago,
                         IF(R.PAGO_id is not null,(SELECT IF(PAG.tipo='E','&nbsp',PAG.nombreBanco)
                                                   FROM PAGO PAG
                                                   WHERE R.PAGO_id = PAG.id),'&nbsp') as banco,
                         IF(R.PAGO_id is not null,(SELECT IF(PAG.tipo='E','&nbsp',PAG.numeroTransaccion)
                                                   FROM PAGO PAG
                                                   WHERE R.PAGO_id = PAG.id),'&nbsp') as numeroTran,
                         IF(R.PAGO_id is not null,(SELECT PAG.monto
                                                   FROM PAGO PAG
                                                   WHERE R.PAGO_id = PAG.id),'&nbsp') as monto,
                         IF((SELECT R.id
                             FROM PAGO PAG, BOLETO BOL
                             WHERE R.PAGO_id = PAG.id
                             AND PAG.id = BOL.PAGO_id
                             GROUP BY(R.id)),TRUE,FALSE) as boleto,
                         IF(VR.tipo = 'ida',IFNULL((SELECT CONCAT(VU.fecha,', ',VU.hora)
                                                    FROM VUELO_RESERVA VRE, VUELO VU , RESERVA RE
                                                    WHERE RE.id = VRE.RESERVA_id
                                                    AND VU.id = VRE.VUELO_id
                                                    AND RE.solicitud = R.solicitud
                                                    AND VRE.tipo = 'vuelta'
                                                    GROUP BY VU.fecha,VU.hora),'SIN RETORNO'),'RT') as vueloRetorno
            FROM VUELO V, VUELO_RESERVA VR, SUCURSAL S, RESERVA R, PASAJERO P, TIPO_SERVICIO TS, ENCARGADO E, TIPO_PASAJERO TP,
                 CLIENTE_PARTICULAR CP, CLIENTE_AGENCIA CA, BOLETO B
            WHERE V.id = VR.VUELO_id
            AND R.id = VR.RESERVA_id
            AND VR.VUELO_id = ".$idVuelo."
            AND TP.id = P.TIPO_PASAJERO_id
            AND TS.id = R.TIPO_SERVICIO_id
            AND S.id = R.SUCURSAL_id
            AND E.cedula = R.ENCARGADO_cedula
            AND (R.CLIENTE_PARTICULAR_cedula = CP.cedula
                 OR R.CLIENTE_AGENCIA_rif = CA.rif)
            GROUP BY(R.id)
            ORDER BY(R.id)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para obtener informacion de un vuelo especifico
     * @param <type> $idVuelo El id del vuelo a consultar
     * @return <type> La informacion del vuelo 
     */
    function consultarInformacionVuelo($idVuelo){
        $query = "SELECT V.fecha, V.hora, R.sitioSalida, R.sitioLlegada,
                         IFNULL((SELECT VU.AVION_matricula
                                 FROM VUELO VU, AVION AV
                                 WHERE VU.id = V.id
                                 AND VU.AVION_matricula = AV.matricula), 
                                'PA') as matricula,
                         IFNULL((SELECT AV.asientos-COUNT(VRE.RESERVA_id)+V.cantidadInfantes
                                 FROM VUELO_RESERVA VRE, VUELO VU , RESERVA RE, AVION AV
                                 WHERE RE.id = VRE.RESERVA_id
                                 AND VU.id = VRE.VUELO_id
                                 AND VRE.VUELO_id = V.id
                                 AND AV.matricula = VU.AVION_matricula),0) as adlChlQuedan,
                         IFNULL((SELECT 2-VU.cantidadInfantes
                                 FROM VUELO VU
                                 WHERE VU.id = V.id),0) as infQuedan,
                         IFNULL((SELECT CONCAT(PE.nombre,' ',PE.apellido)
                                 FROM PERSONAL PE, VUELO VU, VUELO_PERSONAL VP, TIPO_CARGO TC
                                 WHERE PE.cedula = VP.PERSONAL_cedula
                                 AND VU.id = V.id
                                 AND VU.id = VP.VUELO_id
                                 AND TC.id = PE.TIPO_CARGO_id
                                 AND VP.cargo = 1),'PA') as piloto,
                         IFNULL((SELECT CONCAT(PE.nombre,' ',PE.apellido)
                                 FROM PERSONAL PE, VUELO VU, VUELO_PERSONAL VP, TIPO_CARGO TC
                                 WHERE PE.cedula = VP.PERSONAL_cedula
                                 AND VU.id = V.id
                                 AND VU.id = VP.VUELO_id
                                 AND TC.id = PE.TIPO_CARGO_id
                                 AND VP.cargo = 2),'PA') as copiloto
                  FROM VUELO V, RUTA R
                  WHERE V.id = ".$idVuelo."
                  AND R.sitioSalida = V.RUTA_sitioSalida
                  AND R.sitioLlegada = V.RUTA_sitioLlegada ";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar los clientes con mas reservas pagadas
     * @param <type> $idSucursal El id de la sucursal a consultar
     * @param <type> $fechaInicio La fecha de inicio a consultar
     * @param <type> $fechaFin La fecha de fin a consultar
     * @return <type> Los clientes con mas vuelos
     */
    function consultarClienteConMasVuelos($idSucursal,$fechaInicio,$fechaFin){
        $query = "SELECT r.id,r.CLIENTE_PARTICULAR_cedula as particular,r.CLIENTE_AGENCIA_rif as agencia,
                         if(r.CLIENTE_PARTICULAR_cedula is null,(SELECT ca.nombre FROM CLIENTE_AGENCIA ca WHERE r.CLIENTE_AGENCIA_rif = ca.rif),(SELECT CONCAT(cp.nombre,' ',cp.apellido) FROM CLIENTE_PARTICULAR cp WHERE r.CLIENTE_PARTICULAR_cedula = cp.cedula)) as cliente,
                         if(r.CLIENTE_PARTICULAR_cedula is null,COUNT(r.CLIENTE_AGENCIA_rif),COUNT(r.CLIENTE_PARTICULAR_cedula)) as cantidad
                  FROM SUCURSAL s, RESERVA r
                  WHERE s.id = r.SUCURSAL_id
                  AND s.id = ".$idSucursal."
                  AND r.estado = 'PA'
                  AND r.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."'
                  GROUP BY agencia,particular
                  ORDER BY cantidad desc";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar un vuelo especifico, con el campo de busqueda y por fecha
     * @param <String> $busqueda Parametro que contiene la busqueda correspondiente
     * @return <recurso> recurso con los vuelos asociados a esa búsqueda
     */
    function consultarTodosVuelosPorFechaRutas($busqueda) {
        $resultado = false;
        $query = "SELECT v.id id, v.fecha fecha, v.hora hora,
                         ru.abreviaturaSalida rutaSalida,
                         ru.abreviaturaLlegada rutaLlegada,
                         v.AVION_matricula matricula
                  FROM VUELO v, RUTA ru
                  WHERE (ru.abreviaturaSalida LIKE '%".$busqueda."%' OR ru.abreviaturaLlegada LIKE '%".$busqueda."%'
                  OR v.AVION_matricula LIKE '%".$busqueda."%' OR v.fecha LIKE'%".$busqueda."%')
                  AND v.RUTA_sitioLlegada = ru.sitioLlegada
                  AND v.RUTA_sitioSalida = ru.sitioSalida
                  GROUP BY v.id
                  ORDER BY v.fecha DESC ,v.hora DESC";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar la cantidad de infantes por vuelo
     * @param <Integer> $idVuelo Identificador del vuelo
     * @return <recurso> recurso con la cantidad de infantes del vuelo
     */
    function consultarCantidadInfantesVuelo($idVuelo) {
        $resultado = false;
        $query = "SELECT v.cantidadInfantes
                  FROM VUELO v
                  WHERE v.id = ".$idVuelo."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar las horas de los vuelos
     * @param <type> $fechaIni La fecha de inicio a partir de la cual se desea
     * hacer la consulta
     * @param <type> $fechaFin La fecha de fin hasta la cual se desea hacer la
     * consulta
     * @return <recurso> Recurso con la cantidad de horas de los vuelos
     */
    function consultarHorasDeVuelo($fechaIni,$fechaFin) {
        $resultado = false;
        $query = "SELECT SUM(r.tiempo) horasVuelo
                  FROM VUELO v, RUTA r
                  WHERE v.RUTA_sitioSalida = r.sitioSalida
                  AND v.RUTA_sitioLlegada = r.sitioLlegada
                  AND v.id IN (SELECT VUELO_id
                               FROM VUELO_RESERVA)
                  AND v.fecha  BETWEEN '".$fechaIni."' AND '".$fechaFin."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function existeReservaVuelo($idVuelo,$solitud){
        $query = "SELECT R.id
                  FROM RESERVA R, VUELO_RESERVA VR, VUELO V
                  WHERE R.solicitud = '".$solitud."'
                  AND R.id = VR.RESERVA_id
                  AND V.id = VR.VUELO_id
                  AND V.id = ".$idVuelo."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        $cantidad = mysql_num_rows($resultado);
        if($cantidad != 0){
            return true;
        }else{
            return false;
        }
    }
}
?>