/**
 * App - Núcleo de la aplicación Vue.js
 * Estructura modular para ConsoleAsistente
 */
const App = {
  // Estado global
  data: {
    mensaje: [],
    actividad: '',
    actividades: [],
    consola: [],
    messages: [],
    estado: 'Inicializando...',
    classMicro: 'micro-in',
    classMicroIco: 'fas fa-microphone',
    classEnviar: 'enviar-on',
    classComanON: 'ComanOFF',
    classComanOFF: 'ComanON',
    hora: '',
    fecha: '',
    comandosActivos: false
  },

  // Instancia Vue
  vue: null,

  /**
   * Inicializar la aplicación
   */
  init() {
    this.configurarVue();
    this.cargarModulos();
    this.configurarTiempo();
    this.mostrarEstado();
  },

  /**
   * Configurar instancia Vue
   */
  configurarVue() {
    this.vue = new Vue({
      el: '#app',
      data: App.data,
      mounted() {
        App.onMounted();
      },
      updated() {
        App.scrollToBottom();
      },
      methods: {
        // Toggle comandos de voz
        toggleComandos(estado) {
          if (estado === 1) {
            VoiceCommands.activar();
            App.data.classComanON = 'ComanON';
            App.data.classComanOFF = 'ComanOFF';
            App.data.comandosActivos = true;
          } else {
            VoiceCommands.desactivar();
            App.data.classComanON = 'ComanOFF';
            App.data.classComanOFF = 'ComanON';
            App.data.comandosActivos = false;
          }
        },

        // Activar micrófono
        activarMicrofono() {
          if (typeof Escuchar === 'function') {
            Escuchar();
          }
          App.data.classMicro = 'micro-on';
          App.data.classEnviar = 'enviar-in';
        },

        // Actualizar chat (procesar input del usuario)
        actualizarChat() {
          const cadena = App.data.actividad || $('#actividad')?.value;

          if (!cadena || cadena.trim() === '') {
            return false;
          }

          // Preparar datos
          const User = localStorage.getItem('user')?.slice(-2)?.toUpperCase() || 'Us';
          const data = {
            user: User,
            message: cadena,
            rol: 'User'
          };

          // Procesar con NlpProcessor
          const procesado = NlpProcessor.procesar(cadena);
          data.limpia = procesado.limpia;
          data.palabras = procesado.palabras;
          data.original = cadena;

          // Mostrar mensaje del usuario
          output.messageUser(data);

          // Limpiar input
          App.data.actividad = null;

          // Verificar palabras desconocidas
          UnknownWordHandler.verificar(data).then(result => {
            if (result.desconocida) {
              duda.palabra = data.palabras;
              duda.original = data.limpia;
            } else {
              // Buscar respuesta
              App.buscarRespuesta(data);
            }
          });
        },

        // Buscar respuesta en base de datos
        async buscarRespuesta(data) {
          const respuesta = await ResponseFinder.buscar(data.limpia);

          if (respuesta && respuesta.existe) {
            output.messageIA(respuesta.mensaje);
          } else {
            output.messageIA('Lo siento, no tengo respuesta para eso');
          }
        },

        // Monitorear teclado
        keymonitor() {
          setTimeout(() => {
            if (!App.data.actividad) {
              App.data.classMicro = 'micro-in';
              App.data.classEnviar = 'enviar-on';
            } else {
              App.data.classMicro = 'micro-on';
              App.data.classEnviar = 'enviar-in';
            }
          }, 100);
        }
      }
    });
  },

  /**
   * Cargar módulos modulares
   */
  cargarModulos() {
    if (typeof include === 'function') {
      include('home/N.comandos');
      include('home/N.funcionesComandos');
      include('home/output');
    }
  },

  /**
   * Configurar actualización de tiempo
   */
  configurarTiempo() {
    const actualizar = () => {
      const ahora = new Date();
      App.data.hora = ahora.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
      App.data.fecha = ahora.toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' });
    };
    actualizar();
    setInterval(actualizar, 60000);
  },

  /**
   * Mostrar estado inicial
   */
  mostrarEstado() {
    // Verificar soporte de comandos de voz
    if (typeof annyang !== 'undefined') {
      this.vue.estado = 'Comandos por voz soportada';
    } else {
      this.vue.estado = 'Voz por comandos no soportada';
    }

    // Mensaje inicial
    this.vue.mensaje.push({
      consola: ':: Asistente ::'
    });
  },

  /**
   * Callback cuando Vue se monta
   */
  onMounted() {
    consola('log', 'App Vue inicializada');
  },

  /**
   * Scroll automático al final del historial
   */
  scrollToBottom() {
    const messageDisplay = this.vue.$refs.messageDisplay;
    if (messageDisplay) {
      messageDisplay.scrollTop = messageDisplay.scrollHeight;
    }
  }
};

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => App.init());
} else {
  App.init();
}