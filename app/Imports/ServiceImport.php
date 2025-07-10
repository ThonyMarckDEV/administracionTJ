<?php

namespace App\Imports;

use App\Models\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ServiceImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Validar que los campos necesarios existan y no estén vacíos
                if (
                    empty($row['nombre']) ||
                    empty($row['costo']) ||
                    empty($row['fecha_inicio']) ||
                    empty($row['estado'])
                ) {
                    continue; // Saltar fila incompleta
                }

                // Normalizar estado y convertir a booleano
                $estado = strtolower(trim($row['estado']));
                if (!in_array($estado, ['activo', 'inactivo', 'pendiente'])) {
                    continue; // Saltar si el estado no es válido
                }
                $estadoBool = $estado === 'activo';

                // Formatear la fecha
                $rawDate = $row['fecha_inicio'];
                if (is_numeric($rawDate)) {
                    // Fecha como número serial de Excel
                    $fecha = Carbon::instance(Date::excelToDateTimeObject($rawDate))->format('Y-m-d');
                } else {
                    // Fecha como texto
                    $fecha = Carbon::parse(trim($rawDate))->format('Y-m-d');
                }

                // Crear el servicio
                Service::create([
                    'name'      => trim($row['nombre']),
                    'cost'      => (float) $row['costo'],
                    'ini_date'  => $fecha,
                    'state'     => $estadoBool,
                ]);

            } catch (\Exception $e) {
                Log::error('Error importando fila de servicio: ' . $e->getMessage());
                continue;
            }
        }
    }
}
