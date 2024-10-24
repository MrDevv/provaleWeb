CREATE PROCEDURE sp_producto_registrar
    @descripcion VARCHAR(18),
    @abreviatura VARCHAR(5),
    @unidadMedida VARCHAR(30),
    @fechaRegistro DATETIME
AS
BEGIN

    IF NOT EXISTS (SELECT 1 FROM Producto WHERE @descripcion = @descripcion)
    BEGIN

		DECLARE @codEstadoProducto INT

		SELECT @codEstadoProducto = codEstado FROM Estados WHERE abreviatura = 'a';

        
        INSERT INTO Producto (descripcion, abreviatura, unidadMedida, fechaRegistro)
        VALUES (@descripcion, @abreviatura, @unidadMedida, @fechaRegistro);

		PRINT 'Producto registrado exitosamente.';

    END
	ELSE
	BEGIN
		PRINT 'Error ya existe un producto registrado;'
	END
END;