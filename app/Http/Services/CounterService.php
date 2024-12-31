<?php
namespace App\Http\Services;

use App\Models\Counter;

class CounterService
{
    public static function getNextSequence(string $collectionName): int
    {
        // Buscar el documento del contador para la colección dada
        $counter = Counter::where('collectionName', $collectionName)->first();

        if (!$counter) {
            // Si no existe, inicializar la secuencia en 1
            $counter = Counter::create([
                'collectionName' => $collectionName,
                'sequence' => 1,
            ]);
            return 1;
        }

        // Incrementar el valor de la secuencia de forma atómica
        $updated = Counter::where('collectionName', $collectionName)
            ->update([
                'sequence' => $counter->sequence + 1,
            ]);

        if ($updated) {
            return $counter->sequence + 1;
        }

        throw new \Exception("Error al incrementar el contador para {$collectionName}");
    }
}
