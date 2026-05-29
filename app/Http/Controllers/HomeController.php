<?php
/**
 * HomeController - Controller principal del asistente
 * Maneja las requests de la interfaz web
 */
require_once __DIR__ . '/BaseController.php';

class HomeController extends BaseController
{
    private $qb;

    public function __construct()
    {
        parent::__construct();
        $this->qb = new PtcQueryBuilder($this->getPdo());
    }

    /**
     * Página principal - muestra configuración del asistente
     * Alias: home() para compatibilidad con rutas
     */
    public function index()
    {
        $datos = $this->qb->table('personal')
            ->select(['dato', 'valor'])
            ->where('id', '=', 1)
            ->or_where('id', '=', 2)
            ->run();

        return [
            'datos' => $datos,
        ];
    }

    // Alias para compatibilidad con rutas
    public function home()
    {
        return $this->index();
    }

    /**
     * Procesa una pregunta y devuelve respuesta
     */
    public function pregunta()
    {
        $data = $this->getJsonInput();
        $pregunta = $this->qb->table('preguntas')
            ->select(['id', 'equivalente'])
            ->where('pregunta', 'like', $data['pregunta'] ?? '')
            ->run();

        if (!isset($pregunta[0])) {
            // No existe la pregunta - guardarla
            $this->qb->table('preguntas')
                ->insert([
                    'pregunta' => $data['pregunta'] ?? '',
                    'pregunta_original' => $data['original'] ?? ''
                ])
                ->run();

            return $this->jsonResponse([
                'respuesta0' => 'no te entiendo',
                'nose' => 1,
                'Nrespuestas' => 0
            ]);
        }

        // Obtener id_pregunta (considerar equivalente)
        $id_pregunta = ($pregunta[0]['equivalente'] == 0)
            ? $pregunta[0]['id']
            : $pregunta[0]['equivalente'];

        // Buscar respuestas con peso
        $respuestas = $this->qb->table('tipo_respuesta_peso')
            ->select(['respuestas.respuesta'])
            ->join('respuestas', 'respuestas.id', '=', 'tipo_respuesta_peso.respuesta')
            ->where('tipo_respuesta_peso.id_pregunta', '=', $id_pregunta)
            ->run();

        $Nrespuestas = $this->qb->countRows();

        return $this->jsonResponse([
            'respuesta' => $respuestas,
            'nose' => 0,
            'Nrespuestas' => $Nrespuestas
        ]);
    }

    /**
     * Verifica si una palabra existe, si no la guarda
     */
    public function palabras()
    {
        $data = $this->getJsonInput();
        $palabra = $this->qb->table('palabras')
            ->select(['id'])
            ->where('palabras', '=', $data['palabra'] ?? '')
            ->run();

        if (!isset($palabra[0])) {
            $this->qb->table('palabras')
                ->insert(['palabras' => $data['palabra'] ?? ''])
                ->run();
            $respuesta = 'false';
        } else {
            $respuesta = 'true';
        }

        return $this->jsonResponse([
            'palabra' => $data['palabra'] ?? '',
            'respuesta' => $respuesta
        ]);
    }

    /**
     * Agrega una nueva respuesta a una pregunta
     */
    public function respuesta()
    {
        $data = $this->getJsonInput();

        if (isset($data['id']) && $data['id'] != 0) {
            // Insertar nueva respuesta
            $this->qb->table('respuestas')
                ->insert([
                    'respuesta' => $data['pregunta'] ?? '',
                    'id_pregunta' => $data['id']
                ])
                ->run();

            // Obtener ID de la respuesta insertada
            $respuesta = $this->qb->table('respuestas')
                ->select(['MAX(id)'])
                ->where('id_pregunta', '=', $data['id'])
                ->run();

            // Vincular respuesta con pregunta en tipo_respuesta_peso
            if (isset($respuesta[0][0])) {
                $this->qb->table('tipo_respuesta_peso')
                    ->insert([
                        'respuesta' => $respuesta[0][0],
                        'id_pregunta' => $data['id']
                    ])
                    ->run();
            }

            // Actualizar contador de respuestas
            $Nrespuestas = ((int) ($data['Nrespuestas'] ?? 0)) + 1;
            $this->qb->table('preguntas')
                ->where('id', '=', $data['id'])
                ->update(['Nrespuestas' => $Nrespuestas])
                ->run();
        }

        // Obtener pregunta aleatoria con pocas respuestas
        $pregunta = $this->qb->table('preguntas')
            ->select(['preguntas.id', 'preguntas.pregunta_original', 'preguntas.Nrespuestas'])
            ->join('tipo_respuesta_peso', 'preguntas.id', '!=', 'tipo_respuesta_peso.id_pregunta')
            ->order('preguntas.Nrespuestas', 'ASC')
            ->limit(3)
            ->run();

        $r = rand(0, 2);
        $id = $pregunta[$r][0] ?? 0;
        $Nrespuestas = $pregunta[$r]['Nrespuestas'] ?? 0;
        $preguntaTexto = '¿' . ucfirst(strtolower($pregunta[$r]['pregunta_original'] ?? '')) . '?';

        return $this->jsonResponse([
            'id' => $id,
            'pregunta' => $preguntaTexto,
            'Nrespuestas' => $Nrespuestas
        ]);
    }

    /**
     * Devuelve configuración del asistente
     */
    public function config()
    {
        $personal = $this->qb->table('personal')
            ->select(['dato', 'valor'])
            ->run();

        return $this->jsonResponse([
            'config' => $personal
        ]);
    }

    /**
     * Muestra la página de configuración del LLM
     */
    public function configPage()
    {
        // Esta vista se carga desde routes/web.php
        return [];
    }
}