<?php
/**
 * WordRepository - Repositorio para tabla palabras
 */
class WordRepository
{
    private $qb;

    public function __construct($pdo)
    {
        $this->qb = new PtcQueryBuilder($pdo);
    }

    /**
     * Verifica si una palabra existe
     */
    public function exists($palabra)
    {
        $result = $this->qb->table('palabras')
            ->select(['id'])
            ->where('palabras', '=', $palabra)
            ->run();

        return isset($result[0]);
    }

    /**
     * Obtiene palabra por texto
     */
    public function findByWord($palabra)
    {
        return $this->qb->table('palabras')
            ->select(['id', 'palabras'])
            ->where('palabras', '=', $palabra)
            ->run();
    }

    /**
     * Guarda nueva palabra
     */
    public function save($palabra)
    {
        if (!$this->exists($palabra)) {
            $this->qb->table('palabras')
                ->insert(['palabras' => $palabra])
                ->run();
            return true;
        }
        return false;
    }

    /**
     * Obtiene todas las palabras
     */
    public function getAll()
    {
        return $this->qb->table('palabras')
            ->select(['id', 'palabras'])
            ->run();
    }

    /**
     * Busca palabras relacionadas
     */
    public function search($termino)
    {
        return $this->qb->table('palabras')
            ->select(['id', 'palabras'])
            ->where('palabras', 'like', '%' . $termino . '%')
            ->run();
    }

    /**
     * Cuenta total de palabras
     */
    public function count()
    {
        return $this->qb->table('palabras')
            ->select(['COUNT(*) as total'])
            ->run();
    }
}