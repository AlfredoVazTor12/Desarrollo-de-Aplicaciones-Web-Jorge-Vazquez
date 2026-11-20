<?php
session_start();
require '../config/conexion.php';
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) { exit; }

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id'] ?? 0);
$nombre = trim($data['nombre'] ?? '');
$tecnologia = $data['tecnologia'] ?? '';
$progreso = intval($data['progreso'] ?? 0);

$stmt = $pdo->prepare("UPDATE proyectos SET nombre = ?, tecnologia = ?, progreso = ? WHERE id = ?");
if ($stmt->execute([$nombre, $tecnologia, $progreso, $id])) {
    echo json_encode(['status' => 'success', 'message' => 'Proyecto actualizado correctamente.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar.']);
}
?>
