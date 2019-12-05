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
                <span class="message" :class='item.isclass'
                    :name="item.user">{{ item.message }}<i>{{ item.time}}</i></span>
            </li>
        </ul>
    </div>

    <div id="get" CnsA="2.2.3">
        <input type="text" v-on:keyup.enter="actualizarChat" v-on:keyup="keymonitor" v-model="actividad" name="entrada"
            id="actividad" placeholder="Escribe un mensaje aquí">
        <button id="micro" :class="classMicro" v-on:click="micro">
            <i :class="classMicroIco"></i>
        </button>
        <button id="enviar" :class="classEnviar" v-on:click="actualizarChat">
            <i class="fas fa-play"></i>
        </button>
    </div>