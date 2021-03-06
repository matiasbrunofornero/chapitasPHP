<?php namespace DAO;

use Modelo\Petshop as Petshop;
use Config\Conexion as Conexion;

class petshopDAO extends Conexion implements IDAO
{
    public $con;
    protected static $instance;

    private function __construct(){}

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function insertar($petshop)
    {
        try
        {
            $nombre = $petshop->getNombre();
            $direccion = $petshop->getDireccion();
        
            $con = new Conexion();
            $conexion = $con->conectar();
            $sql = "insert into petshops values(NULL, :nombre, :direccion)";
        
            $statement = $conexion->prepare($sql);
			$statement->bindParam(":nombre", $nombre);
			$statement->bindParam(":direccion", $direccion);

			$statement->execute();
        }
        catch (PDOException $e)
        {
            $message = $e->getMessage();
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }

    public function eliminar($nombre)
    {
        try
        {
            $con = new Conexion();
            $conexion = $con->conectar();
            $resultado = null;

            $sql = "delete from petshops where nombre = :nombre";
    
            $statement = $conexion->prepare($sql);
            $statement->bindParam(':nombre', $nombre);
            $statement->execute();
        }
        catch (PDOException $e)
        {
            $message = $e->getMessage();
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        $con = null;
    }

    public function listar()
    {
        $fila = null;
        try 
        {
            $con = new Conexion();
            $conexion = $con->conectar();

            $sql = "SELECT * FROM petshops ORDER BY Nombre ASC";

            $statement = $conexion->prepare($sql);
            $statement->execute();
            $resultado = $statement->fetchAll();
        }
        catch (PDOException $e)
        {
            $message = $e->getMessage();
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        $con = null;
        return $resultado;
    }

    public function buscar($nombre)
    {
        try
        {
            $con = new Conexion();
            $conexion = $con->conectar();
            $resultado = null;

            $sql = "select * from petshops where nombre = :nombre";

            $statement = $conexion->prepare($sql);
            $statement->bindParam(':nombre', $nombre);
            $statement->execute();

            $resultado = $statement->fetchAll();
        }
        catch (PDOException $e)
        {
            $message = $e->getMessage();
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        $con = null;
        return $resultado;
    }
}