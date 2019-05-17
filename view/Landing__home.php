<?php 
#@header
define("Titulo", "Console Assistant");
include 'partials/header_partials.php'; 
#@END::header

#@END::header
echo Console::log('_variable', ['Landing_home'=>$Landing_home["datos"][1]['valor']],'log',$debug);

#@header-html
include 'partials/Landing__header_partials.php';
?>
<section id="app">
    <header id="header" CnsA="1.0">
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
                <div id="estado">
                    <span id="title">Estado:</span>
                    <span>{{ estado }}</span>
                </div>
                <!--  -->

                <h4 class="card-title "><?=$Landing_home["datos"][0]['dato'].' '.$Landing_home["datos"][0]['valor']?></h4>	
				<?php foreach($Landing_home["datos"] AS $datos):?>
					<?=$datos["dato"]?>
					<?=$datos["valor"]?><BR>  
				<?php endforeach?>

                <div id="container" class="container">
                <table>
                        <tr v-for="(item, index) in mensaje">
                            <td>{{ item.consola }}</td>
                        </tr>
                </table>
                <table class="bordertable">
                    <tr>
                        <th>comando</th>
                        <th>entrada</th>
                    </tr>
                    <tr>
                        <td>hola</td>
                        <td>voz/comando</td>
                    </tr>
                    <tr>
                        <td>pedir la edad</td>
                        <td>voz</td>
                    </tr>
                    <tr>
                            <td>escuchar</td>
                            <td>voz</td>
                        </tr>
                        <tr>
                                <td>adiós</td>
                                <td>voz/comando</td>
                            </tr>
                </table>
                <button onclick="Escuchar();">Escuchar</button>
                <button onclick="NoEscuchar();">dejar de escuchat</button> <br>
                <button onclick="comandosOn()">comandos por voz</button>
                <button onclick="comandosOff()">apagar comandos por voz</button><br>
				<textarea id="actividad2">Entrada</textarea>   
            
<center style="
display:none;
position: fixed;
background: linear-gradient(45deg, #212121 15px, rgba(255, 255, 255, 0.08) 15px, #212121 16px), linear-gradient(-45deg, #212121 15px, rgba(255, 255, 255, 0.08) 15px, #212121 16px);
padding: 20px; 
opacity: 0.8;
transform: rotateY(-25deg) rotateX(0deg) translateY(100%);
">
            <span style="
                color: #00bebe;
                font-size: 25px;
                font-family: 'Orbitron', sans-serif;
                text-shadow:1px 1px 13px rgba(25, 210, 100, 0.6)
            ">
            This is a test message!
            </span>
                <button style="
                border: 1px solid rgb(0, 190, 190);
    background:#212121;;
    color: rgb(0, 190, 190);
    tex-shadow: 0 0 5px #00dcdc, 0 0 5px #00dcdc inset;
    font-size: 25px;
    box-shadow: 0 0 5px #00dcdc, 0 0 5px #00dcdc inset;
    -webkit-clip-path: polygon(0 20%, 20% 0, 100% 0, 100% 80%, 80% 100%, 0 100%);
                ">boton</button>
                <button style="-webkit-clip-path: polygon(0 20%, 20% 0, 100% 0, 100% 80%, 80% 100%, 0 100%);">dialogo</button>
</center>
                </div>
            </code>
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