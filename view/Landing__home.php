<?php 
#@header
define("Titulo", "Console Asisitent");
include 'partials/header_partials.php'; 
#@END::header

#@END::header
echo Console::log('_variable', ['Landing_home'=>$Landing_home["datos"][1]['valor']],'log',$debug);

#@header-html
include 'partials/Landing__header_partials.php';
?>				
        <main id="body" CnsA="2.0">
            <code CnsA="2.1">
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
                <button onclick="comandosOff()">apagar comandos por voz</button>
				<textarea id="actividad2">Entrada</textarea>
				
				<h4 class="card-title "><?=$Landing_home["datos"][0]['dato'].' '.$Landing_home["datos"][0]['valor']?></h4>	
				<?php foreach($Landing_home["datos"] AS $datos):?>
					<?=$datos["dato"]?>
					<?=$datos["valor"]?><BR>  
				<?php endforeach?>

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
                        <img src="storage/logo/ico.ico" height="100%">
                    </span>
                    <ul id="User" v-for="(item, index) in actividades">
                        <li v-bind:class="[item.rol]">
                            <span class="nombre">{{ item.user }}</span>
                            <span class="message">{{ item.message }}</span>
                        </li>
                    </ul>
                </div>
                <div id="get" CnsA="2.2.3">
                    <input type="text" v-on:keyup.enter="actualizarChat" v-on:keyup="keymonitor" v-model="actividad" name="entrada"
                        id="actividad"  placeholder="Enter para confirmar">
                    <button id="micro" :class="classMicro" v-on:click="micro">
                        <i :class="classMicroIco"></i>
                    </button>
                    <button id="enviar" :class="classEnviar" v-on:click="actualizarChat">
                        <i class="fas fa-play"></i>
                    </button>
                </div>
            </article>
        </main>
<?php 
#@footer-html
include 'partials/Landing__footer_partials.php';
#@END::footer
#
#footer/Scripts
include 'partials/footer_partials.php'; 
#@END::footer
?>
