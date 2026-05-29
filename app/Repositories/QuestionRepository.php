<?php
/**
 * QuestionRepository - Repositorio para tabla preguntas
 */
class QuestionRepository
{
    private $qb;
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->qb = new PtcQueryBuilder($pdo);
    }

    /**
     * Busca pregunta por texto
     */
    public function findByQuestion($texto)
    {
        return $this->qb->table('preguntas')
            ->select(['id', 'pregunta', 'pregunta_original', 'equivalente', 'Nrespuestas'])
            ->where('pregunta', 'like', $texto)
            ->run();
    }

    /**
     * Busca pregunta por ID
     */
    public function findById($id)
    {
        return $this->qb->table('preguntas')
            ->select(['id', 'pregunta', 'pregunta_original', 'equivalente', 'Nrespuestas'])
            ->where('id', '=', $id)
            ->run();
    }

    /**
     * Crea nueva pregunta
     */
    public function create($pregunta, $original)
    {
        $this->qb->table('preguntas')
            ->insert([
                'pregunta' => $pregunta,
                'pregunta_original' => $original,
                'equivalente' => 0,
                'Nrespuestas' => 0
            ])
            ->run();

        return $this->qb->lastId();
    }

    /**
     * Actualiza contador de respuestas
     */
    public function incrementResponses($id)
    {
        $pregunta = $this->findById($id);
        if (isset($pregunta[0])) {
            $n = ((int) $pregunta[0]['Nrespuestas']) + 1;
            $this->qb->where('id', '=', $id)
                ->update(['Nrespuestas' => $n])
                ->run();
        }
    }

    /**
     * Obtiene preguntas con pocas respuestas (para aprender)
     */
    public function getForLearning($limit = 10)
    {
        return $this->qb->table('preguntas')
            ->select(['id', 'pregunta_original', 'Nrespuestas'])
            ->order('Nrespuestas', 'ASC')
            ->limit($limit)
            ->run();
    }

    /**
     * Busca pregunta equivalente
     */
    public function getEquivalent($id)
    {
        $pregunta = $this->findById($id);
        if (isset($pregunta[0]) && $pregunta[0]['equivalente'] > 0) {
            return $this->findById($pregunta[0]['equivalente']);
        }
        return $pregunta;
    }
}