<?php
/**
 * Modelo Clase Usuario
 *
 * @category Class
 * @package  Model
 * @author   Andres Garcia <afagrcia0479@misena.edu.co>
 * @license  <a href="www.mit.org">mit</a>
 * @version  GIT:<ASD4A6S54DASD>
 * @link     www.github.com/andgar2010
 *
 * This Model of Class User
 * Source DB
 */



/**
 * Modelo Clase Usuario
 *
 * @category Class
 * @package  Model
 * @author   Andres Garcia <afagrcia0479@misena.edu.co>
 * @license  <a href="www.mit.org">mit</a>
 * @Release  GIT:<ASD4A6S54DASD>
 * @link     www.github.com/andgar2010
 *
 * This Model of Class User
 * Source DB
 */
class Usuario
{
    public $id_usuario;
    public $documento;
    public $cod_tipo_doc;
    public $nombre;
    public $apellido;
    public $cod_genero;
    public $email;
    public $password;
    public $cod_area;
    public $cod_cargo;
    public $cod_rol;
    public $cod_estado;
    public $fecha_creado;
    public $encontradoDB;

    /**
     * This Construct Class Usuario
     */
    public function __construct()
    {

    }

    /**
     * Function sanitize
     *
     * $var @param String
     * This inpur string
     *
     * @return String
     * $vareturn vareturn
     */
    function sanitize($var)
    {
        include '../config/Database.php';
        return $db->real_escape_string($var);
    }

    /**
     * Crear usuario al BD mediante metodo por objeto usuario
     *
     * @return Boolean $insertadoClienteDb
     */
    function createUser()
    {
        define('ACTIVO', '2');//Defecto num 2: Activo por ENUM Estado de Ususario

        include '../config/Database.php';
        $sql_insert = "INSERT INTO `usuario`
                            (`cod_tipo_doc`, `documento`, `apellido`, `nombre`, `cod_genero`, `email`, `password`, `cod_area`, `cod_cargo`, `cod_rol`, `cod_estado`)
                        VALUES (
                            '".$this->cod_tipo_doc."',
                            '".$this->documento."',
                            '".$this->apellido."',
                            '".$this->nombre."',
                            '".$this->cod_genero."',
                            '".$this->email."',
                            '".$this->password."',
                            '".$this->cod_area."',
                            '".$this->cod_cargo."',
                            '".$this->cod_rol."',
                            '".ACTIVO."')";

        $insertadoClienteDb = $db->query($sql_insert) or die('<h1 class="text-center">Oooops!</h1><br>Hubo un error al registrar al Usuario. <br><br><strong>Origen error:</strong><br>' . mysqli_error($db));
        //$insertadoClienteDb->close();
        $db->close();
        return ($insertadoClienteDb) ? true : false;
    }

    /**
     * Consultar lista de usuarios
     *
     * @return String arrayListUsers
     */
    function readUser()
    {
        include '../config/Database.php';
        $sql_query = "SELECT * FROM usuario";

        if ($output_sql = $db->query($sql_query)) {

            if ($row = $output_sql->num_rows == 0) {
                echo'
                <tr>
                    <td colspan="8">No hay datos</td>
                </tr>';
            } else {
                while ($row = $output_sql->fetch_assoc()) {
                    $numID = 1;
                    echo'
                    <tr>
                        <td class="text-center">'.$row['id_usuario'].'</td>
                        <td>
                            <a href="profile.php?nik='.$row['id_usuario'].'">
                            <span class="fa fa-user fa-lg" aria-hidden="true">&nbsp;</span>'.
                                $row['nombre'].' '. $row['apellido'].
                            '</a> </td>
                            <td class="text-center">'. $row['cod_cargo'].'</td>
                            <td class="text-center">'. $row['cod_area'].'</td>
                            <td class="text-center">'. $row['cod_rol'].'</td>';

                            switch ($row['cod_estado']) {
                                case 'Inactivo':
                                    echo '
                                        <td class="text-center">
                                            <span class="label label-info">inactivo</span>
                                        </td>';
                                    break;
                                case 'Activo':
                                    echo '
                                        <td class="text-center">
                                            <span class="label label-success">Activo</span>
                                        </td>';
                                    break;
                                default:
                                    echo '
                                        <td class="text-center">
                                            <span class="label label-warning">No seleccionado</span>
                                        </td>';
                                    break;
                            }

                            echo'
                            </td>
                            <td class="text-center">
                                <a href="viewEditUser.php?id='.$row['id_usuario'].'" title="Editar datos" class="btn btn-primary btn-sm">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> </a>
                                <a href="index.php?aksi=delete&nik='.$row['id_usuario'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombre']. ' '. $row['apellido'] .'? \')" class="btn btn-danger btn-sm">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>
                            </td>
                    </tr>';

                            $numID++;
                }

                $output_sql->close();
            }
            $db->close();
        }
    }//End readUser()

    /**
     * Consultar unico usuario
     *
     * @return Usuario objeto
     */
    function readSingleRecordUsuer($id_usuario)
    {
        include '../config/Database.php';
        $sql_query = "SELECT * FROM usuario WHERE id_usuario =". $id_usuario;

        if ($output_sql = $db->query($sql_query)) {

            if ($output_sql->num_rows == 0) {
                // Si no encontrado usuario en BD
                return $encontradoDB = false;
            } else {
                // Si encontrado datos de usuario en BD, recoge los datos al this objeto.
                $encontradoDB = true;

                /* fetch object array */
                while ($obj = $output_sql->fetch_object()) {
                    $this->id_usuario   = $this->sanitize($obj->id_usuario);
                    $this->cod_tipo_doc = $this->sanitize($obj->cod_tipo_doc);
                    $this->documento    = $this->sanitize($obj->documento);
                    $this->nombre       = $this->sanitize($obj->nombre);
                    $this->apellido     = $this->sanitize($obj->apellido);
                    $this->cod_genero   = $this->sanitize($obj->cod_genero);
                    $this->email        = $this->sanitize($obj->email);
                    $this->cod_area     = $this->sanitize($obj->cod_area);
                    $this->cod_cargo    = $this->sanitize($obj->cod_cargo);
                    $this->cod_rol      = $this->sanitize($obj->cod_rol);
                    $this->cod_estado   = $this->sanitize($obj->cod_estado);
                    //$this->password      = $this->sanitize($passwordRandom);
                    // $usuario->password      = $usuario->sanitize(password_hash($passwordRandom, PASSWORD_DEFAULT));
                    //$fecha_creado =  ;//Format Timedate BD '2018-05-13 16:40:39'
                }

                /* fetch associative array */
                // while ($row = $result->fetch_assoc()) {
                //     printf ("%s (%s)\n", $row["Name"], $row["CountryCode"]);
                //     $this->id_usuario    = $this->sanitize($row['id_usuario']);
                //     $this->cod_tipo_doc  = $this->sanitize($row['cod_tipo_doc']);
                //     $this->documento     = $this->sanitize($row['num_cedula']);
                //     $this->nombre        = $this->sanitize($row['nombre']);
                //     $this->apellido      = $this->sanitize($row['apellido']);
                //     $this->cod_genero    = $this->sanitize($row['cod_genero']);
                //     $this->email         = $this->sanitize($row['email']);
                //     $this->cod_area      = $this->sanitize($row['cod_area']);
                //     $this->cod_cargo     = $this->sanitize($row['cod_cargo']);
                //     $this->cod_rol       = $this->sanitize($row['cod_rol']);
                //     $this->cod_estado    = $this->sanitize($row['cod_estado']);
                    //$this->password       = $this->sanitize($passwordRandom);
                    // $usuario->password   = $usuario->sanitize(password_hash($passwordRandom, PASSWORD_DEFAULT));
                    //$fecha_creado =  ;//Format Timedate BD '2018-05-13 16:40:39'
            }
            /* free output_sql set */
            $output_sql->close();
        }
        /* close connection */
        $db->close();
    }
}
?>