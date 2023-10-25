<?php
class ConexionDB{
    private static $instancia =null;
    private $conexion;

    private function __construct(){
        $dsn = 'mysql:host=localhost;dbname=productos2';
        $username = 'root';
        $password = '';
        try {
            $this->conexion = new PDO($dsn,$username,$password);
           /*  echo "conexión exitosa" . PHP_EOL; */ //genera conflicto con el objeto que devuelve
        }catch (PDOException $e){
            echo "Error al conectarse: " .$e->getMessage();
        }
    }
//metodo publico para obtener una sola instancia de conexion
    public static function getInstancia(){
        if (self::$instancia === null) {
            self::$instancia = new ConexionDB();
        }
        return self::$instancia;
    }
    public function getConexion(){
        return $this->conexion;
    }

    public function ejecutarConsulta($sql, $parametros = array()) {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($parametros);
            return $stmt;
        } catch (PDOException $e) {
            die("Error al ejecutar la consulta: " . $e->getMessage());
        }
    }

    public function obtenerResultados($sql, $parametros = array()) {
        $stmt = $this->ejecutarConsulta($sql, $parametros);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>