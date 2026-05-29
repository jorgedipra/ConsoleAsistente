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
          // Capturar el valor directamente del input DOM
          const inputEl = document.getElementById('actividad');
          const cadena = inputEl ? inputEl.value.trim() : '';

          console.log('actualizarChat - input value:', cadena);

          if (!cadena) {
            return false;
          }

          // Guardar mensaje original
          const mensajeOriginal = cadena;

          // Preparar datos
          const User = localStorage.getItem('user')?.slice(-2)?.toUpperCase() || 'Us';
          const data = {
            user: User,
            message: mensajeOriginal,
            rol: 'User',
            limpia: mensajeOriginal,
            original: mensajeOriginal
          };

          // Mostrar mensaje del usuario inmediatamente
          output.messageUser(data);

          // Limpiar input
          if (inputEl) inputEl.value = '';
          App.data.actividad = '';
          this.actividad = '';

          // Enviar directamente al LLM
          console.log('Enviando al LLM:', mensajeOriginal);
          this.enviarALLM(mensajeOriginal);
        },

        // Enviar mensaje al LLM
        async enviarALLM(mensaje) {
          try {
            console.log('=== ENVIANDO AL LLM ===');
            console.log('Mensaje original:', mensaje);
            console.log('========================');

            const payload = {
              mensaje: mensaje,
              historial: []
            };
            console.log('Payload:', payload);

            const response = await fetch('/api/llm/chat', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify(payload)
            });

            const data = await response.json();
            console.log('Response del LLM:', data);

            if (data.respuesta) {
              // Limpiar HTML de la respuesta
              const respuestaLimpia = data.respuesta
                .replace(/<br\s*\/?>/gi, '\n')
                .replace(/<[^>]+>/g, '')
                .trim();
              output.messageIA(respuestaLimpia);
            } else if (data.error) {
              console.error('Error del servidor:', data.error);
              output.messageIA('Error: ' + data.error);
            } else {
              output.messageIA('No pude obtener una respuesta');
            }
          } catch (error) {
            console.error('Error al consultar LLM:', error);
            output.messageIA('Lo siento, no pude procesar tu solicitud');
          }
        },

        // Buscar respuesta en base de datos
        async buscarRespuesta(data) {
          try {
            const respuesta = await ResponseFinder.buscar(data.limpia);

            if (respuesta && respuesta.existe) {
              // Respuesta encontrada en base de datos local
              output.messageIA(respuesta.mensaje);
            } else {
              // No hay respuesta local, consultar al LLM
              const respuestaLlm = await axios.post('/api/llm/chat', {
                mensaje: data.original || data.limpia,
                historial: []
              });

              if (respuestaLlm.data.respuesta) {
                output.messageIA(respuestaLlm.data.respuesta);
              } else {
                output.messageIA('No pude obtener una respuesta');
              }
            }
          } catch (error) {
            console.error('Error en buscarRespuesta:', error);
            output.messageIA('Lo siento, ocurrió un error al procesar tu solicitud');
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