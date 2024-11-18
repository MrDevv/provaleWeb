--- guardar beneficiario ---
CREATE PROCEDURE sp_beneficiario_guardar(
  @persona_nombres VARCHAR(100),
  @persona_apellidoPaterno VARCHAR(50),
  @persona_apellidoMaterno VARCHAR(50),
  @persona_dni VARCHAR(8),
  @persona_sexo CHAR(1),
  @persona_telefono VARCHAR(6) = NULL,
  @persona_celular VARCHAR(9) = NULL,
  @persona_fechaNacimiento DATE,
  @persona_codSectorZona INT,
  @persona_direccion VARCHAR(100),
  @persona_numeroFinca INT = NULL,
  @beneficiario_codSocio INT,    
  @beneficiario_codParentesco INT = NULL,
  @historico_codTipoBeneficio INT = NULL,  
  @historico_peso DECIMAL(9,3) = NULL,
  @historico_talla DECIMAL(9,2) = NULL,
  @historico_hmg DECIMAL(9,2) = NULL,
  @historico_fechaUltimaMestruacion DATE = NULL,
  @historico_fechaProbableParto DATE = NULL,
  @historico_fechaParto DATE = NULL,
  @historico_fechaFinLactancia DATE = NULL
)
AS
BEGIN
  SET NOCOUNT ON
  BEGIN TRY
    BEGIN TRANSACTION    

    DECLARE @codEstadoActivo INT
  
    SELECT @codEstadoActivo = codEstado FROM Estados WHERE abreviatura = 'a'         
  
    INSERT INTO Personas(nombres, apellidoPaterno, apellidoMaterno, dni, sexo, telefono, celular, fechaNacimiento,
    codSectorZona, direccion, numeroFinca) 
    VALUES (@persona_nombres, @persona_apellidoPaterno, @persona_apellidoMaterno, @persona_dni, @persona_sexo,
    @persona_telefono, @persona_celular, @persona_fechaNacimiento, @persona_codSectorZona, @persona_direccion,
    @persona_numeroFinca)  
  
    DECLARE @codPersonaInsert INT;
    SET @codPersonaInsert = SCOPE_IDENTITY();    
  

    INSERT INTO Beneficiarios(codPersona, codSocio, codParentesco)
    VALUES(@codPersonaInsert, @beneficiario_codSocio, @beneficiario_codParentesco)
    
    DECLARE @codBeneficiarioInsert INT;
    SET @codBeneficiarioInsert = SCOPE_IDENTITY();
    
    INSERT INTO HistoricoBeneficiarios(codTipoBeneficio, codBeneficiario, peso, talla, hmg, fechaUltimaMestruacion,
    fechaProbableParto, fechaDeParto, fechaFinLactancia, codEstado)
    VALUES(@historico_codTipoBeneficio, @codBeneficiarioInsert, @historico_peso, @historico_talla, @historico_hmg, @historico_fechaUltimaMestruacion,
    @historico_fechaProbableParto, @historico_fechaParto, @historico_fechaFinLactancia, @codEstadoActivo)
       
    
    COMMIT TRAN;
    SELECT 'success' as 'status'
    END TRY
    BEGIN CATCH
      DECLARE 
      @ErrorMessage VARCHAR(2048),
      @ErServery INT,
      @ErState INT

      SELECT
        @ErrorMessage = ERROR_MESSAGE(),
        @ErServery = ERROR_SEVERITY(),
        @ErState = ERROR_STATE()

      ROLLBACK TRAN;					
      SELECT 'error' AS 'status', @ErrorMessage AS ErrorMessage, @ErServery AS Severity, @ErState AS State;
    END CATCH;  
END