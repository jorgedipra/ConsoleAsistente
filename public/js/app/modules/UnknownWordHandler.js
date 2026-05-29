/**
 * UnknownWordHandler - Manejo de palabras desconocidas
 * Consolida: N.duda.js
 */
class UnknownWordHandler {
  constructor() {
    this.palabra = [];
    this.ciclos = 0;
    this.original = '';
    this.status = undefined;
    this.count = 0;
  }

  /**
   * Verifica si hay palabras desconocidas
   */
  static async verificar(data) {
    const palabras = JSON.parse(data.palabras || '[]');
    const originales = data.original.split(' ');

    // Por cada palabra, verificar si existe en el vocabulario
    for (let i = 0; i < palabras.length; i++) {
      const palabra = palabras[i].toUpperCase().trim();

      // Saltar palabras vacías y conectores
      if (!palabra || ['Y', 'DE', 'EL', 'LA', 'EN', 'QUE', 'ES', 'A', 'POR', 'ESTÁ'].includes(palabra)) {
        continue;
      }

      // Verificar en vocabulario
      try {
        const respuesta = await axios.post('palabras', { palabra });
        if (respuesta.data.respuesta === 'false') {
          // Palabra desconocida - guardar
          duda.status = 100; // Modo aprendizaje
          return {
            desconocida: true,
            palabra: palabra,
            posicion: i
          };
        }
      } catch (error) {
        consola('error', 'UnknownWordHandler.verificar', error);
      }
    }

    duda.status = undefined;
    return { desconocida: false };
  }

  /**
   * Proceso para aprender el significado de una palabra
   */
  static async aprenderSignificado(palabra, significado) {
    // Guardar la palabra en vocabulario
    try {
      await axios.post('palabras', { palabra });
      consola('log', `Palabra aprendida: ${palabra}`);
    } catch (error) {
      consola('error', 'Error aprendiendo palabra', error);
    }

    duda.status = undefined;
    return true;
  }

  /**
   * Proceso para guardar nombre de usuario
   */
  static guardarNombre(data) {
    const nombre = data.message;
    localStorage.setItem('user', nombre);
    return nombre;
  }

  /**
   * Obtiene el nombre guardado del usuario
   */
  static obtenerNombre() {
    const nombre = localStorage.getItem('user');
    return nombre ? nombre.charAt(0).toUpperCase() + nombre.slice(1) : null;
  }
}

// Instancia global para manejo de dudas
var duda = new UnknownWordHandler();