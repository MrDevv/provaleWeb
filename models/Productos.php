<?php

class Productos{

    private int $codProducto;
    private string $descripcion;
    private string $abreviatura;
    private int $codUnidadMedida;
    private int $stock;
    private string $precioUnitario;
    private int $codEstado;

    public function getCodProducto(): int{
        return $this->codProducto;
    }

    public function setCodProducto(int $codProducto): void{
        $this->codProducto = $codProducto;
    }

    public function getDescripcion(): string{
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void{
        $this->descripcion = $descripcion;
    }

    public function getAbreviatura(): string{
        return $this->abreviatura;
    }

    public function setAbreviatura(string $abreviatura): void{
        $this->abreviatura = $abreviatura;
    }

    public function getCodUnidadMedida(): int{
        return $this->unidadMedida;
    }

    public function setCodUnidadMedida(int $codUnidadMedida): void{
        $this->codUnidadMedida = $codUnidadMedida;
    }

    public function getStock(): int{
        return $this->getStock;
    }

    public function setStock(int $stock): void{
        $this->stock = $stock;
    }

    public function getPrecioUnitario(): string{
        return $this->getPrecioUnitario;
    }

    public function setPreciounitario(string $precioUnitario): void{
        $this->precioUnitario = $precioUnitario;
    }

    public function getCodEstado(): int{
        return $this->getCodEstado;
    }

    public function setCodEstado(int $codEstado): void{
        $this->codEstado = $codEstado;
    }

    public function listarProductos($descripcion){
        $sql = "EXEC sp_producto_listar :descripcion";

        try{
            $stmt = DataBase::connect()->prepare($sql);
            $stmt->bindParam('descripcion',$descripcion, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'lista de productos',
                'action' => 'listarProductos',
                'module' => 'productos',
                'data' => $result,
                'info' => '',
            ];
        }catch (PDOException $e){
            return [
                'status' => 'failed',
                'code' => 500,
                'message' => 'Ocurrio un error al momento de listar los productos',
                'action' => 'listarProductos',
                'module' => 'productos',
                'data' => [],
                'info' => $e->getMessage()
            ];
        }
    }

    public function guardarProductos(){
        $sql = "EXEC sp_producto_registrar :descripcion, :abreviatura, :codUnidadMedida";

        try {
            $stmt = DataBase::connect()->prepare($sql);
            $stmt->bindParam('descripcion',$this->descripcion, PDO::PARAM_STR);
            $stmt->bindParam('abreviatura',$this->abreviatura, PDO::PARAM_STR);
            $stmt->bindParam('codUnidadMedida',$this->codUnidadMedida, PDO::PARAM_INT); 
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Producto registrado exitosamente',
                    'data' => [],
                ];
            }else {
                return [
                    'status' => 'failed',
                    'code' => 400,
                    'message' => 'No se pudo registrar el producto, verifica los datos',
                    'action' => 'guardarProducto',
                    'module' => 'productos',
                    'data' => [],
                ];
            }
        }catch (PDOException $e) {
            return [
                'status' => 'failed',
                'code' => 500,
                'message' => 'Ocurrio un error al momento de guardar los productos',
                'action' => 'guardarProducto',
                'module' => 'productos',
                'data' => [],
                'info' => $e->getMessage()
            ]; 
        }
    }

    public function actualizarProductos(){
        $sql="EXEC sp_producto_actualizar :codProducto, :descripcion, :abreviatura, :codUnidadMedida";

        try {
            $stmt = DataBase::connect()->prepare($sql);
            $stmt->bindParam('codProducto',$this->codProducto, PDO::PARAM_INT);
            $stmt->bindParam('descripcion',$this->descripcion, PDO::PARAM_STR);
            $stmt->bindParam('abreviatura',$this->abreviatura, PDO::PARAM_STR);
            $stmt->bindParam('codUnidadMedida',$this->codUnidadMedida, PDO::PARAM_INT); 
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Producto actualizado exitosamente',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'failed',
                    'code' => 400,
                    'message' => 'No se pudo actualizar el producto, verifica los datos',
                    'action' => 'actualizarProducto',
                    'module' => 'productos',
                    'data' => [],
                ];
            }
        }catch (PDOException $e){
            return [
                'status' => 'failed',
                'code' => 500,
                'message' => 'Ocurrio un error al momento de actualizar los productos',
                'action' => 'actualizarProducto',
                'module' => 'productos',
                'data' => [],
                'info' => $e->getMessage()
            ];
        }
    }

}

