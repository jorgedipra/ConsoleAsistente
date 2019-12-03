<?php
//http://phptoolcase.com/api/0.9.2/query_builder.html

class Landing__Controller extends Controller
{

    public function home($id = '', $var = '')
    {

        $qb = new PtcQueryBuilder($this->pdo());

        $datos = $qb->table('personal')
            ->select(array('dato', 'valor'))
            ->where('id', '=', 1)
            ->or_where('id', '=', 2)
            ->run();

        return $view = [
            'datos' => $datos,
        ];
    } ##->END function home

    public function pregunta($id = '', $var = '')
    {
        $qb = new PtcQueryBuilder($this->pdo());
        $data = json_decode(file_get_contents("php://input")); //captura de datos con Json
        $nose = 0;
        $pregunta = $qb->table('preguntas')
            ->select(array('id', 'equivalente'))
            ->where('pregunta', 'like', $data->pregunta)
            ->run();

        if (!isset($pregunta[0])): //No sabe la respuesta
            $qb->table('preguntas')
                ->insert(array('pregunta' => $data->pregunta, 'pregunta_original' => $data->original))
                ->run();
            $respuestas = "{ 'respuesta0': :'no te entiendo' }";
            $Nrespuestas = 0;
            $nose = 1;

        else:
            if ($pregunta[0]['equivalente'] == 0) {
                $id_pregunta = $pregunta[0]['id'];
            } else {
                $id_pregunta = $pregunta[0]['equivalente'];
            }
            $respuestas = $qb->table('tipo_respuesta_peso')
                ->select(['respuestas.respuesta'])
                ->join('respuestas', 'respuestas.id', '=', 'tipo_respuesta_peso.respuesta')
                ->where('tipo_respuesta_peso.id_pregunta', '=', $id_pregunta)
                ->run();
            $Nrespuestas = $qb->countRows();
        endif;
        return $view = [
            'respuesta' => $respuestas,
            'nose' => $nose,
            'Nrespuestas' => $Nrespuestas,
        ];
    } ##->END funtion pregunta

    public function palabras($id = '', $var = '')
    {
        $qb = new PtcQueryBuilder($this->pdo());
        $data = json_decode(file_get_contents("php://input"));
        $respuesta = "true";
        $palabra = $qb->table('palabras')
            ->select(array('id'))
            ->where('palabras', '=', $data->palabra)
            ->run();

        if (!isset($palabra[0])):
            $qb->table('palabras')
                ->insert(array('palabras' => $data->palabra))
                ->run();
            $respuesta = "false";
        endif;

        return $view = [
            'palabra' => $data->palabra,
            'respuesta' => $respuesta,
        ];
    } ##->END funtion palabras
    public function respuesta($id = '', $var = '')
    {
        $qb = new PtcQueryBuilder($this->pdo());
        $data = json_decode(file_get_contents("php://input"));
        if ($data->id != 0):
            $qb->table('respuestas')
                ->insert(['respuesta' => $data->pregunta, 'id_pregunta' => $data->id])
                ->run();
            $respuesta = $qb->table('respuestas')
                ->select(['MAX(id)'])
                ->where('id_pregunta', '=', $data->id)
                ->run();
            $qb->table('tipo_respuesta_peso')
                ->insert(['respuesta' => $respuesta[0][0], 'id_pregunta' => $data->id])
                ->run();
            $Nrespuestas = (int) $data->Nrespuestas + 1;
            $qb->table('preguntas')
                ->where('id', '=', $data->id)
                ->update(array('Nrespuestas' => $Nrespuestas))
                ->run();
        endif;
        $pregunta = $qb->table('preguntas')
            ->select(['preguntas.id', 'preguntas.pregunta_original', 'preguntas.Nrespuestas'])
            ->join('tipo_respuesta_peso', 'preguntas.id', '!=', 'tipo_respuesta_peso.id_pregunta')
            ->order('preguntas.Nrespuestas', 'ASC')
            ->limit(3)
            ->run();
        $r = (int) rand(0, 2);
        $id = $pregunta[$r][0];
        $Nrespuestas = $pregunta[$r]['Nrespuestas'];
        $pregunta = "¿" . ucfirst(strtolower($pregunta[$r]['pregunta_original'])) . "?";

        return $view = [
            'id' => $id,
            'pregunta' => $pregunta,
            'Nrespuestas' => $Nrespuestas,
        ];

    } ##->END funtion respuesta
    public function _404($id = '', $var = '')
    {
        if ($id == true):
            echo "id [" . $id . "]";
            echo "var [" . $var . "]";
        endif;

    } //::END->_404

} ##->END class landing__Controller
