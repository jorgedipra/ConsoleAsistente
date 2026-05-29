<?php
#@header
define("Titulo", "Console Assistant");
include 'partials/header_partials.php';
#@END::header

#@END::header
echo Console::log('_variable', ['Landing_home' => $Landing_home["datos"][1]['valor']], 'table', $debug);

#@header-html
include 'partials/Landing__header_partials.php';
?>

<section id="app">
    <!-- HEADER -->
    <header id="header">
        <div id="hora" class="color-wh text-left">
            {{ hora }} <br> {{ fecha }}
        </div>
        <div id="comand">
            <span>Comandos Voz</span>
            <button id="comandoON" :class="classComanON" onclick="comandosOff()" v-on:click="ComanVoz(0)">
                <span>ON</span>
            </button>
            <button id="comandoOFF" :class="classComanOFF" onclick="comandosOn()" v-on:click="ComanVoz(1)">
                <span>OFF</span>
            </button>
            <button id="btn-config-header" class="btn-config-header" onclick="abrirConfigModal()">
                <span><i class="fas fa-cog"></i> Configuración</span>
            </button>
        </div>
    </header>

    <!-- BODY - Dos columnas -->
    <main id="body">

        <!-- PANEL IZQUIERDO (60%) -->
        <section id="panel-izq">

            <!-- Estado del Asistente -->
            <div id="estado-caja">
                <span id="title">Estado:</span>
                <span class="estado-texto">{{ estado }}</span>
            </div>

            <!-- Título -->
            <div id="titulo-caja">
                <h4 class="card-title text-center font-robot" v-for="(item, index) in mensaje">
                    {{ item.consola }}
                </h4>
            </div>

            <!-- Tablero de Comandos -->
            <div id="tabla-comandos">
                <code id="code">
                    <article id="temp"></article>
                    <?php include 'partials/home.tablero.php'; ?>
                </code>
            </div>

        </section>

        <!-- PANEL DERECHO (40%) -->
        <section id="panel-der">

            <!-- Historial de Chat -->
            <div id="historial-caja">
                <div ref='messageDisplay' id="historial">
                    <span id="msginicial">
                        Alis - te habla
                        <img src="storage/public/home/interface4.gif" height="100%">
                    </span>
                    <ul id="User" v-for="(item, index) in actividades">
                        <li v-bind:class="[item.rol]">
                            <span class="nombre">{{ item.user }}</span>
                            <span class="message" :class='item.isclass'>
                                <span v-if="item.html" v-html="item.html"></span>
                                <span v-else>{{ item.message }}</span>
                                <i>{{ item.time}}</i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Input de Chat -->
            <div id="input-caja">
                <div id="get">
                    <input type="text" v-on:keyup.enter="actualizarChat" v-on:keyup="keymonitor"
                           v-model="actividad" name="entrada" id="actividad" placeholder="Escribe un mensaje aquí...">
                    <button id="micro" :class="classMicro" v-on:click="micro">
                        <i :class="classMicroIco"></i>
                    </button>
                    <button id="enviar" :class="classEnviar" v-on:click="actualizarChat">
                        <i class="fas fa-play"></i>
                    </button>
                </div>
            </div>

            
        </section>

    </main>
</section>

<?php
#@footer-html
include 'partials/Landing__footer_partials.php';
#@END::footer

#footer/Scripts
include 'partials/footer_partials.php';
#@END::footer
?>