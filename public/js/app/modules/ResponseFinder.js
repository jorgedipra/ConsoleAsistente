/**
 * ResponseFinder - Buscador de respuestas
 * Consolida: N.respuestas.js
 */
class ResponseFinder {
  constructor() {
    this.status = undefined;
    this.cadena = '';
  }

  /**
   * Busca respuesta en base de datos
   */
  static async buscar(cadena) {
    try {
      const response = await axios.post('pregunta', {
        pregunta: cadena,
        original: cadena.replace(/[¿?]/g, '')
      });

      const json = response.data;

      if (json.indexOf && json.indexOf('<script') > 0) {
        // Handle HTML response with embedded content
        const partes = json.split('<script');
        const data = JSON.parse(partes[0]);
        return ResponseFinder.procesarRespuesta(data);
      }

      return ResponseFinder.procesarRespuesta(json);
    } catch (error) {
      consola('error', 'ResponseFinder.buscar', error);
      return null;
    }
  }

  /**
   * Procesa respuesta del servidor
   */
  static procesarRespuesta(json) {
    const respuesta = {
      existe: false,
      mensaje: '',
      cantidad: 0
    };

    try {
      const cantidad = parseInt(json.Nrespuestas) || 0;

      if (cantidad === 0 || json.nose === 1) {
        respuesta.existe = false;
        respuesta.mensaje = 'no te entiendo';
      } else {
        respuesta.existe = true;
        respuesta.cantidad = cantidad;

        // Buscar la respuesta en el objeto
        let respuestas = [];
        for (const key in json) {
          if (json[key] && typeof json[key] === 'string' && key.indexOf('respuesta') === 0) {
            respuestas.push(json[key]);
          }
        }

        // Si no hay respuestas específicas, buscar en array
        if (respuestas.length === 0 && json.respuesta) {
          if (Array.isArray(json.respuesta)) {
            respuestas = json.respuesta;
          } else {
            respuestas = [json.respuesta];
          }
        }

        // Seleccionar respuesta aleatoria
        if (respuestas.length > 0) {
          const r = Math.floor(Math.random() * respuestas.length);
          respuesta.mensaje = respuestas[r];
        }
      }
    } catch (e) {
      consola('error', 'Error procesando respuesta', e);
    }

    return respuesta;
  }

  /**
   * Agrega nueva respuesta a una pregunta
   */
  static async agregarRespuesta(idPregunta, respuesta) {
    try {
      const response = await axios.post('respuesta', {
        id: idPregunta,
        pregunta: respuesta,
        Nrespuestas: 0
      });

      return response.data;
    } catch (error) {
      consola('error', 'ResponseFinder.agregarRespuesta', error);
      return null;
    }
  }

  /**
   * Verifica si una palabra es conocida
   */
  static async verificarPalabra(palabra) {
    try {
      const response = await axios.post('palabras', {
        palabra: palabra
      });

      return response.data;
    } catch (error) {
      consola('error', 'ResponseFinder.verificarPalabra', error);
      return null;
    }
  }
}