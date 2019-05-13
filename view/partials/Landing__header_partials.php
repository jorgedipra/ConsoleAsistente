<section id="app">
        <footer id="footer" CnsA="1.0">
                <div id="comand">
                        <span>Comandos Voz</span>
                        <button id="comandoON"  :class="classComanON" onclick="comandosOff()" v-on:click="ComanVoz(0)">ON</button>
                        <button id="comandoOFF" :class="classComanOFF" onclick="comandosOn()" v-on:click="ComanVoz(1)">OFF</button>
                </div>

        </footer>