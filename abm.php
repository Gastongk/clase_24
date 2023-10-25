<?php
require_once 'productos.php';
require_once 'conexion.php';
header('content-Type: application/json');
class ABM {

    public function listar() {
               
        $productos = Producto::listarTodos();
        return $productos;
        
    }

    public function agregar($nombre, $precio, $cantidad){

        if (Producto::guardar($nombre, $precio, $cantidad)) {
            /* echo 'Producto guardado exitosamente.'; */
            echo json_encode (true);
        } else {
          /*   echo 'Error al guardar el producto.'; */
          echo json_encode(false);
        }
    }    

    public function menu() {
        echo "Opciones disponibles:\n";
        echo "1. Agregar producto\n";
        echo "2. Editar producto\n";
        echo "3. Eliminar producto\n";
        echo "4. Listar productos\n";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'listar') {
        // Listar todos los productos
        $abm = new ABM();
        $productos = $abm->listar();
     /*    print_r($productos); */
        echo json_encode($productos);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        $abm = new ABM();
        if ($accion === 'agregar') {
            if (isset($_POST['nombre'], $_POST['precio'], $_POST['cantidad'])) {
                $nombre = $_POST['nombre'];
                $precio = $_POST['precio'];
                $cantidad = $_POST['cantidad'];

                $abm->agregar($nombre, $precio, $cantidad);
            } else {
                echo 'Faltan datos para agregar el producto.';
            }
        } elseif ($accion === 'buscarPorId') {
            // Lógica para modificar un producto
            $id = $_POST['id'];
            $producto = Producto::buscarPorId($id);
            if ($producto) {
                echo json_encode(['success' => true, 'producto' => $producto]);
            } else {
                echo json_encode(['success' => false]);
            }
        } elseif ($accion === 'actualizar') {
            // Lógica para eliminar un producto
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $cantidad = $_POST['cantidad'];

            $actualizado = Producto::actualizar($id, $nombre, $precio, $cantidad);
            if ($actualizado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } elseif ($accion === 'eliminar') {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                
                $eliminado = Producto::eliminar($id);
                if ($eliminado) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false]);
                }
            } else {
                echo 'Falta el ID para eliminar el producto.';
            }
        } else {
            echo 'Opción no válida.';
        }
    } else {
        echo 'Opción no especificada.';
    }
}


/* if ($_POST['accion'] === 'buscarPorId') {
    $id = $_POST['id'];
    $producto = Producto::buscarPorId($id);
    if ($producto) {
        echo json_encode(['success' => true, 'producto' => $producto]);
    } else {
        echo json_encode(['success' => false]);
    }
} 
 if ($_POST['accion'] === 'actualizar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $actualizado = Producto::actualizar($id, $nombre, $precio, $cantidad);
    if ($actualizado) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} 
<!-- permite acceder a los valores de las propiedades privadas

$conexionDB = ConexionDB::getInstancia();
            
            $sql = "SELECT * FROM productos";
            $resultados = $conexionDB->obtenerResultados($sql);
            return $resultados; 
            $productos = [];
            foreach($resultados as $r){
                $producto = new stdClass;
                $producto->id = $r['id'];
                $productos[] = $producto;
                
            }
               return $productos; -->
               */