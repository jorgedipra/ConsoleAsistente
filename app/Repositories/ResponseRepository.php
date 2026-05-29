<?php
/**
 * ResponseRepository - Repositorio para tablas respuestas y tipo_respuesta_peso
 */
class ResponseRepository
{
    private $qb;

    public function __construct($pdo)
    {
        $this->qb = new PtcQueryBuilder($pdo);
    }

    /**
     * Obtiene respuestas de una pregunta (con peso)
     */
    public function findByQuestion($idPregunta)
    {
        return $this->qb->table('tipo_respuesta_peso')
            ->select(['respuestas.id', 'respuestas.respuesta', 'tipo_respuesta_peso.peso'])
            ->join('respuestas', 'respuestas.id', '=', 'tipo_respuesta_peso.respuesta')
            ->where('tipo_respuesta_peso.id_pregunta', '=', $idPregunta)
            ->run();
    }

    /**
     * Agrega nueva respuesta a una pregunta
     */
    public function addResponse($respuesta, $idPregunta)
    {
        // Insertar respuesta
        $this->qb->table('respuestas')
            ->insert([
                'respuesta' => $respuesta,
                'id_pregunta' => $idPregunta,
                'V_emocional' => 0,
                'experiencia' => 0,
                'importancia' => 0
            ])
            ->run();

        $idRespuesta = $this->qb->lastId();

        // Vincular con tipo_respuesta_peso
        $this->qb->table('tipo_respuesta_peso')
            ->insert([
                'id_pregunta' => $idPregunta,
                'respuesta' => $idRespuesta,
                'peso' => 0
            ])
            ->run();

        return $idRespuesta;
    }

    /**
     * Obtiene respuesta aleatoria ponderada
     */
    public function getRandomResponse($idPregunta)
    {
        $respuestas = $this->findByQuestion($idPregunta);
        $total = count($respuestas);

        if ($total === 0) {
            return null;
        }

        // Selección pseudo-aleatoria por peso
        $r = rand(0, $total - 1);
        return $respuestas[$r]['respuesta'] ?? null;
    }

    /**
     * Actualiza peso de respuesta
     */
    public function updateWeight($idRespuesta, $peso)
    {
        $this->qb->table('tipo_respuesta_peso')
            ->where('respuesta', '=', $idRespuesta)
            ->update(['peso' => $peso])
            ->run();
    }

    /**
     * Obtiene última respuesta insertada
     */
    public function getLastInserted()
    {
        return $this->qb->table('respuestas')
            ->select(['MAX(id)'])
            ->run();
    }
}