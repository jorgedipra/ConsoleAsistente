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
    <header id="header" CnsA="1.0">
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
        </div>
    </header>
    <main id="body" CnsA="2.0">
        <section id="tab">

            <!-- [Estado] -->
            <div id="estado">
                <span id="title">Estado:</span>
                <span>{{ estado }}</span>
            </div>
            <!-- [END::Estado] -->

            <h4 class="card-title text-center font-robot top0" v-for="(item, index) in mensaje">
                {{ item.consola }}
            </h4>

            <div id="pestanas" class="btn-group btn-group-toggle" data-toggle="buttons">
                <button type="button" id="wComandos" class="btn btn-outline-success font-robot  movil"
                    onclick="">comandos</button>
                <button type="button" id="wAsistente" class="btn btn-outline-danger font-robot  movil"
                    onclick="">Asistente</button>
            </div>

        </section>

        <code id="code" CnsA="2.1">
            <article ></article>
            <!-- <<[Tablero]>> -->
            <?php include 'partials/home.tablero.php'; ?>     
            <!-- <<[END::Tablero]>> -->
        </code>
        <article id="section2" CnsA="2.2">
            <!-- [Estado-historial] -->
            <?php include 'partials/home.historial.php' ?>
            <!-- [END::Estado-historial] -->
        </article>
    </main>
</section>
<?php
#@footer-html
include 'partials/Landing__footer_partials.php';
#@END::footer
#
#footer/Scripts
include 'partials/footer_partials.php';
#@END::footer
?>