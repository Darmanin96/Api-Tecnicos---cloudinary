<?php
require_once __DIR__ . '/../models/Datos.php';
require_once __DIR__ . '/../view/json.php';

class DatosController {
    private $modelo;
    private $cloudinary;

    public function __construct($dbConn,$cloudinary) {
        $this->modelo = new Datos($dbConn,$cloudinary);
        $this->cloudinary = $cloudinary;
    }

    public function getAll() {
        $data = $this->modelo->obtenerTecnicos();
        renderJSON(["status" => "success", "data" => $data]);
    }

    public function getGastos() {
        $data = $this->modelo->obtenerGastos();
        renderJSON(["status" => "success", "data" => $data]);
    }

  public function deleteGasto() {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        renderJSON(["status" => "error", "message" => "ID es obligatorio para eliminar un gasto"]);
        return;
    }
    $existe = $this->modelo->obtenerGastos(); 
    $existe = array_filter($existe, fn($gasto) => $gasto['id'] == $id);

    if (empty($existe)) {
        renderJSON(["status" => "error", "message" => "No se encontró el gasto con el ID proporcionado"]);
        return;
    }

    $this->modelo->deleteGasto($id);

    renderJSON(["status" => "success", "message" => "Gasto eliminado correctamente"]);
}




public function updateGasto() {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        renderJSON(["status" => "error", "message" => "ID es obligatorio para actualizar un gasto"]);
        return;
    }

    $gastos = $this->modelo->obtenerGastos();
    $existe = array_filter($gastos, fn($g) => $g['id'] == $id);
    if (empty($existe)) {
        renderJSON(["status" => "error", "message" => "No se encontró el gasto con el ID proporcionado"]);
        return;
    }

    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input) {
        renderJSON(["status" => "error", "message" => "No se recibieron datos válidos"]);
        return;
    }

    $nombreTecnico   = $input['nombreTecnico']   ?? null;
    $codigoEmpleado  = $input['codigoEmpleado']  ?? null;
    $delegacion      = $input['delegacion']      ?? null;
    $importe         = $input['importe']         ?? null;
    $fecha           = $input['fecha']           ?? null;
    $imagenAlimento  = $input['imagenAlimento']  ?? null;
    $imagenTicket    = $input['imagenTicket']    ?? null;

    if (!$nombreTecnico || !$codigoEmpleado || !$delegacion || !$importe || !$fecha) {
        renderJSON(["status" => "error", "message" => "Faltan campos obligatorios para actualizar"]);
        return;
    }

    $this->modelo->updateGasto(
        $id,
        $nombreTecnico,
        $codigoEmpleado,
        $delegacion,
        $importe,
        $fecha,
        $imagenAlimento,
        $imagenTicket
    );

    renderJSON(["status" => "success", "message" => "Gasto actualizado correctamente"]);
}



    public function insertarTecnico() {
        $nombreTecnico = $_POST['nombreTecnico'] ?? null;
        $codigoEmpleado = $_POST['codigoEmpleado'] ?? null;
        $delegacion = $_POST['delegacion'] ?? null;
        $importe = $_POST['importe'] ?? null;
        $fecha = $_POST['fecha'] ?? null;
        $imagenAlimento = $_FILES['imagenAlimento'] ?? null;
        $imagenTicket = $_FILES['imagenTicket'] ?? null;

        if (!$nombreTecnico || !$codigoEmpleado || !$delegacion || !$importe || !$fecha || !$imagenAlimento || !$imagenTicket) {
            renderJSON(["status" => "error", "message" => "Faltan datos obligatorios"]);
            return;
        }

        $idInsertado = $this->modelo->introducirTecnicos(
            $nombreTecnico,
            $codigoEmpleado,
            $delegacion,
            $importe,
            $fecha,
            $imagenAlimento,
            $imagenTicket
        );

        renderJSON([
            "status" => "success",
            "id" => $idInsertado,
            "message" => "Técnico insertado correctamente"
        ]);
    }
}
