<?php

namespace Database\Seeders;

use App\Enums\CategoriaTorneo;
use App\Enums\EstadoPartido;
use App\Enums\PosicionJugador;
use App\Models\Equipo;
use App\Models\Noticia;
use App\Models\Partido;
use App\Models\Torneo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatosDemoSeeder extends Seeder
{
    private array $nombres = ['Luis', 'Carlos', 'Diego', 'Jorge', 'Mateo', 'Andrés', 'Rodrigo', 'Fabián', 'Sergio', 'Iván'];
    private array $apellidos = ['Quispe', 'Huamán', 'Mamani', 'Flores', 'Condori', 'Ramos', 'Vargas', 'Rojas', 'Salas', 'Cruz'];

    public function run(): void
    {
        $masculino = Torneo::firstOrCreate(
            ['nombre' => 'Liga Apurímac Masculina', 'temporada' => '2026'],
            ['categoria' => CategoriaTorneo::Hombres, 'fecha_inicio' => now()->subDays(20), 'fecha_fin' => now()->addDays(60), 'activo' => true]
        );
        $femenino = Torneo::firstOrCreate(
            ['nombre' => 'Liga Apurímac Femenina', 'temporada' => '2026'],
            ['categoria' => CategoriaTorneo::Mujeres, 'fecha_inicio' => now()->subDays(10), 'fecha_fin' => now()->addDays(60), 'activo' => true]
        );

        $this->crearTorneo($masculino, [
            ['AND', 'Andes Hawks', 'Abancay', 'Grupo A'],
            ['CUS', 'Cusco Cóndores', 'Cusco', 'Grupo A'],
            ['LIM', 'Lima Titanes', 'Lima', 'Grupo A'],
            ['ARE', 'Arequipa Volcanes', 'Arequipa', 'Grupo B'],
            ['ABA', 'Abancay Pumas', 'Abancay', 'Grupo B'],
            ['PUN', 'Puno Lakers', 'Puno', 'Grupo B'],
        ]);

        $this->crearTorneo($femenino, [
            ['TAC', 'Tacna Águilas', 'Tacna', 'Grupo A'],
            ['ICA', 'Ica Soles', 'Ica', 'Grupo A'],
            ['PIU', 'Piura Tigres', 'Piura', 'Grupo B'],
            ['TRU', 'Trujillo Reinas', 'Trujillo', 'Grupo B'],
        ]);

        $this->crearNoticias();
    }

    private function crearTorneo(Torneo $torneo, array $filas): void
    {
        $equipos = [];
        foreach ($filas as [$sigla, $nombre, $ciudad, $grupo]) {
            $equipo = Equipo::firstOrCreate(
                ['sigla' => $sigla],
                [
                    'nombre' => $nombre,
                    'ciudad' => $ciudad,
                    'entrenador' => 'Prof. ' . $this->apellidos[array_rand($this->apellidos)],
                    'anio_fundacion' => rand(1990, 2018),
                ]
            );
            $this->crearJugadores($equipo);
            $torneo->equipos()->syncWithoutDetaching([
                $equipo->id => ['grupo' => $grupo, 'ajuste_puntos' => 0],
            ]);
            $equipos[] = ['equipo' => $equipo, 'grupo' => $grupo];
        }

        if ($torneo->partidos()->exists()) {
            return;
        }
        $this->crearPartidos($torneo, $equipos);
    }

    private function crearJugadores(Equipo $equipo): void
    {
        if ($equipo->jugadores()->exists()) {
            return;
        }
        $posiciones = PosicionJugador::cases();
        $dorsales = collect(range(4, 30))->shuffle()->take(8)->values();
        foreach ($dorsales as $indice => $dorsal) {
            $equipo->jugadores()->create([
                'nombres' => $this->nombres[array_rand($this->nombres)],
                'apellidos' => $this->apellidos[array_rand($this->apellidos)],
                'dorsal' => $dorsal,
                'posicion' => $posiciones[$indice % count($posiciones)],
                'estatura_cm' => rand(170, 210),
            ]);
        }
    }

    private function crearPartidos(Torneo $torneo, array $equipos): void
    {
        $parejas = [];
        foreach ($equipos as $i => $local) {
            foreach ($equipos as $j => $visitante) {
                if ($j > $i) {
                    $parejas[] = [$local, $visitante];
                }
            }
        }
        $desplazamiento = intdiv(count($parejas), 4);
        foreach ($parejas as $indice => [$local, $visitante]) {
            $dia = intdiv($indice, 2) - $desplazamiento;
            $turno = $indice % 2;
            $estado = match (true) {
                $dia < 0 => EstadoPartido::Finalizado,
                $dia === 0 && $turno === 0 => EstadoPartido::EnVivo,
                default => EstadoPartido::Programado,
            };
            [$puntosLocal, $puntosVisitante] = $this->marcador($estado);
            Partido::create([
                'torneo_id' => $torneo->id,
                'equipo_local_id' => $local['equipo']->id,
                'equipo_visitante_id' => $visitante['equipo']->id,
                'fecha_hora' => now()->addDays($dia)->setTime($turno === 0 ? 17 : 20, 0),
                'fase' => $local['grupo'] === $visitante['grupo']
                    ? 'Fase de grupos · ' . $local['grupo']
                    : 'Fase de grupos · Interzonal',
                'sede' => 'Coliseo ' . $local['equipo']->ciudad,
                'estado' => $estado,
                'puntos_local' => $puntosLocal,
                'puntos_visitante' => $puntosVisitante,
            ]);
        }
    }

    private function marcador(EstadoPartido $estado): array
    {
        if ($estado === EstadoPartido::Programado) {
            return [null, null];
        }
        if ($estado === EstadoPartido::EnVivo) {
            return [rand(20, 52), rand(20, 52)];
        }
        $local = rand(55, 100);
        $visitante = rand(55, 100);
        if ($local === $visitante) {
            $local++;
        }
        return [$local, $visitante];
    }

    private function crearNoticias(): void
    {
        if (Noticia::exists()) {
            return;
        }

        $autor = User::where('email', 'admin@liga.test')->first();
        $noticias = [
            ['Arranca la temporada 2026 con seis equipos en la rama masculina', 'La liga abrió su calendario con jornadas de mucho ritmo y defensas cerradas.'],
            ['Las campeonas defensoras llegan invictas a la tercera fecha', 'El equipo femenino mantiene su racha y lidera la tabla con la mejor defensa del torneo.'],
            ['Nuevo coliseo: así será la sede de las finales', 'La organización confirmó la sede, el aforo y las fechas de semifinales y final.'],
            ['Entrevista con el entrenador revelación del torneo', 'Un repaso a su sistema de juego, la rotación del plantel y las claves de sus últimas victorias.'],
            ['Calendario actualizado: cambios en la jornada del fin de semana', 'Dos partidos se reprograman por la disponibilidad del coliseo. Revisa los nuevos horarios.'],
        ];
        foreach ($noticias as $indice => [$titulo, $resumen]) {
            Noticia::create([
                'autor_id' => $autor?->id,
                'titulo' => $titulo,
                'resumen' => $resumen,
                'contenido' => $resumen . "\n\nEste es un texto de ejemplo creado por el seeder. Puedes editarlo o eliminarlo desde el panel de administración.\n\nLa liga publicará más novedades en los próximos días.",
                'publicada_en' => now()->subHours(($indice + 1) * 9),
            ]);
        }
    }
}