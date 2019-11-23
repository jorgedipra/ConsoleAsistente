<?php
#@header
define("Titulo", "Console Assistant");
include 'partials/header_partials.php';
#@END::header

#@END::header
echo Console::log('_variable', ['Landing_home' => $Landing_home["datos"][1]['valor']], 'log', $debug);

#@header-html
include 'partials/Landing__header_partials.php';
?>
<section id="app">
    <header id="header" CnsA="1.0">
        <div id="hora" class="color-wh">
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
        <code id="code" CnsA="2.1">
            <!-- [Estado] -->
            <div id="estado">
                <span id="title">Estado:</span>
                <span>{{ estado }}</span>
            </div>
            <!-- [END::Estado] -->

                <h4 class="card-title text-center font-robot top1">
                    :: <?=$Landing_home["datos"][0]['dato'] . ' ' . $Landing_home["datos"][0]['valor']?> ::
                </h4>
                <button class="creadores font-robot button2 text-left top2">
				<?php foreach ($Landing_home["datos"] as $datos): ?>
					    [+] <?=$datos["dato"]?> ]:
					        <?=$datos["valor"]?><BR>
				<?php endforeach?>
                </button>
<!-- |||||||||||||||||||||<<[Tablero]>>||||||||||||||||||||| -->
                <div id="container" class="container">
                
                
                <div class="container bordertable card-style font-robot">
                    <div class="row">
                        <div class="col  text-center">
                            <ul class="list-group"  v-for="(item, index) in mensaje">
                                 <li class="list-group-item titulo-lista"> {{ item.consola }} </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success">comando / Tipo</li>
                                <li class="list-group-item">hola = voz/comando</li>
                                <li class="list-group-item">pedir la edad = voz/comando</li>
                                <li class="list-group-item">escuchar = voz/comando</li>
                                <li class="list-group-item">adiós = voz/comando</li>
                            </ul>
                        </div>
                        <div class="col-sm">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-danger">Tipo</li>
                                <li class="list-group-item">
                                <button class="button1 font-robot color-black" onclick="Escuchar();">Escuchar</button>
                                <button class="button1 font-robot" onclick="NoEscuchar();">dejar de escuchat</button> <br>
                                <button class="button1 font-robot color-black" onclick="comandosOn()">comandos por voz</button>
                                <button class="button1 font-robot" onclick="comandosOff()">apagar comandos por voz</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <textarea id="actividad2">Entrada</textarea>
                 

                </div>
<!-- |||||||||||||||||||||<<[END::Tablero]>>||||||||||||||||||||| -->
        </code>
    <!-- [Estado-historial] -->
        <article id="section2" CnsA="2.2">
            <div id="descrip" CnsA="2.2.1">
                <h2>Estado:</h2>
                <ul>
                    <li>{{ estado }}</li>
                </ul>
            </div>

            <div ref='messageDisplay' id="historial" CnsA="2.2.2">
                <span id="msginicial">
                    Alis - te habla
                    <img src="storage/public/home/interface4.gif" height="100%">
                </span>
                <ul id="User" v-for="(item, index) in actividades">
                    <li v-bind:class="[item.rol]">
                        <span class="nombre">{{ item.user }}</span>
                        <span class="message">{{ item.message }}</span>
                    </li>
                </ul>
            </div>
            <div id="get" CnsA="2.2.3">
                <input type="text" v-on:keyup.enter="actualizarChat" v-on:keyup="keymonitor" v-model="actividad"
                    name="entrada" id="actividad" placeholder="Escribe un mensaje aquí">
                <button id="micro" :class="classMicro" v-on:click="micro">
                    <i :class="classMicroIco"></i>
                </button>
                <button id="enviar" :class="classEnviar" v-on:click="actualizarChat">
                    <i class="fas fa-play"></i>
                </button>
            </div>
        </article>
    <!-- [END::Estado-historial] -->
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