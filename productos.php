<?php
require_once 'conexion.php';

class Producto {
    private $id;
    private $nombre;
    private $precio;
    private $cantidad;

    public function __construct($id , $nombre , $precio, $cantidad ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }
    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getPrecio() {
        return $this->precio;
    }
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    
    public function getCantidad() {
        return $this->cantidad;
    }
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public static function listarTodos() {
        $conexionDB = ConexionDB::getInstancia();
        
        $sql = "SELECT * FROM productos";
        $resultados = $conexionDB->obtenerResultados($sql);
        
        $productos = [];
        foreach($resultados as $r){
           /*  $productos[] = new Producto($r['id'], $r['nombre'], $r['precio'], $r['cantidad']); */
            $producto = new stdClass;   //clase estandar para acceder a las propiedades privadas
                $producto->id = $r['id'];
                $producto->nombre = $r['nombre'];
                $producto->precio = $r['precio'];
                $producto->cantidad = $r['cantidad'];
                $productos[] = $producto;
        }
        return $productos;
    }
    
    public static function guardar($nombre, $precio, $cantidad) {
        $conexionDB = ConexionDB::getInstancia();
    
        $sql = "INSERT INTO productos (nombre, precio, cantidad) VALUES (:nombre, :precio, :cantidad)";
        $stmt = $conexionDB->getConexion()->prepare($sql);
    
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
    
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al insertar el producto: " . $e->getMessage();
            return false;
        }
    }

    public static function buscarPorId($id) {
        $conexionDB = ConexionDB::getInstancia();
        
        $sql = "SELECT * FROM productos WHERE id = :id";
        $parametros = [':id' => $id];
        $resultados = $conexionDB->obtenerResultados($sql, $parametros);
        
        if ($resultados) {
            return $resultados[0]; // Devuelve el primer resultado
        } else {
            return null; 
        }
    }

    Public static function actualizar($id, $nombre, $precio, $cantidad) {
        $conexionDB = ConexionDB::getInstancia();
        
        $sql = "UPDATE productos SET nombre = :nombre, precio = :precio, cantidad = :cantidad WHERE id = :id";
        $stmt = $conexionDB->getConexion()->prepare($sql);
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id', $id);
        
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al actualizar el producto: " . $e->getMessage();
            return false;
        }
    }   

    public static function eliminar($id) {
        $conexionDB = ConexionDB::getInstancia();
    
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $conexionDB->getConexion()->prepare($sql);
    
        $stmt->bindParam(':id', $id);
    
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al eliminar el producto: " . $e->getMessage();
            return false;
        }
    }
}


/* 
    public function eliminar() {
        $conexionDB = ConexionDB::getInstancia();
        
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $conexionDB->getConexion()->prepare($sql);
        
        $stmt->bindParam(':id', $this->id);
        
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al eliminar el producto: " . $e->getMessage();
            return false;
        }
    }
} */

/* 
     public function actualizar() {
        $conexionDB = ConexionDB::getInstancia();
        
        $sql = "UPDATE productos SET nombre = :nombre, precio = :precio, cantidad = :cantidad WHERE id = :id";
        $stmt = $conexionDB->getConexion()->prepare($sql);
        
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':cantidad', $this->cantidad);
        $stmt->bindParam(':id', $this->id);
        
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al actualizar el producto: " . $e->getMessage();
            return false;
        }
    } */


    /* public function guardar() {
        $conexionDB = ConexionDB::getInstancia();
        
        $sql = "INSERT INTO productos (nombre, precio, cantidad) VALUES (:nombre, :precio, :cantidad)";
        $stmt = $conexionDB->getConexion()->prepare($sql);
        
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':cantidad', $this->cantidad);
        
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al insertar el producto: " . $e->getMessage();
            return false;
        }
    } */

/* $prod = new Producto(null, '', 0, 0);
$productos = $prod->listarTodos();
print_r($productos); */
?>