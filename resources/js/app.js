/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('log', {
    template:`
    <ul class="list-group">
        <li class="list-group-item" v-for="(log, index) in logs"
        :log="log"
        :key="index">
        Time: {{log.duration}} mins, Type: {{log.type}}<br>
        <small>{{log.created_at}}</small>
        </li>
    </ul>
    `,
    data: function(){
        return{
            logs: [],
        }
    },
    methods: {
        showLog(){
            var self = this;
            axios({
                method: 'get',
                url: '/'
            })
            .then(response =>{
                self.logs = response.data;
                console.log(response.data)
            })
            .catch(error =>{
                console.log(error)
            });
        },
    },
    created() {
        this.showLog();
    },
});

Vue.component('timer', {
    template:`
    <div class="jumbotron" id="app">
        <div class="container has-text-centered">
            <h2 class="title ">{{title}}</h2>
            <div id="timer">
                <span id="minutes">{{ minutes }}</span>
                <span id="middle">:</span>
                <span id="seconds">{{ seconds }}</span>
            </div>

            <div id="buttons">
            <!--     Start Timer Btn    -->
                <button
                id="start"
                class="button text-primary btn-lg"
                v-if="!timer"
                @click="startTimer">
                <i class="far fa-play-circle"></i>
                </button>

            <!--     Pause Timer Btn    -->
                <button
                id="stop"
                class="button text-success btn-lg"
                v-if="timer"
                @click="stopTimer">
                <i class="far fa-pause-circle"></i>
                </button>

            <!--     Restart Timer Btn   -->
                <button
                id="reset"
                class="button text-danger btn-lg"
                v-if="resetButton"
                @click="resetTimer">
                <i class="fas fa-undo"></i>
                </button>

                <button
                id="start"
                class="button text-success btn-lg"
                v-if="!timer"
                @click="addTimer">
                <i class="fas fa-plus"></i>
                </button>

            <!--    Type of Timer selection    -->
                <div class="input-group mt-3">
                    <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Type</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01" v-model="type">
                        <option value="unset" selected>Unset</option>
                        <option value="coding">Coding</option>
                        <option value="reading">Recreational Reading</option>
                        <option value="study">Study</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    `,
    data: function() {
        return{
    timer: null,
    totalTime: (.25 * 60),
    resetButton: true,
    title: "Let the countdown begin!!",
    storeTime: null,
    type: "unset",
        }
    },

    methods: {
    startTimer() {
        this.timer = setInterval(() => this.countdown(), 1000);
        this.storeTime = Math.floor(this.totalTime/60);
        this.resetButton = true;
        this.title = "Greatness is within sight!!"
        console.log(this.storeTime);
    },
    stopTimer() {
        clearInterval(this.timer);
        this.timer = null;
        this.resetButton = true;
        this.title = "Don't quit, keep going!!!"
    },
    resetTimer() {
        this.totalTime = (.25 * 60);
        clearInterval(this.timer);
        this.timer = null;
        this.resetButton = false;
        this.storeTime = [];
        this.title = "Let the countdown begin!!"
    },
    addTimer(){
        this.totalTime = (this.totalTime + .25 * 60);
        console.log('Add');
        this.timer = null;
        this.resetButton = true;
        this.title = "More time!!"
    },
    padTime(time) { // when less than 10 include a zero ie: 09, 08, 07...
        return (time < 10 ? '0' : '') + time;
    },
    saveTime(){
        axios({
                method: 'post',
                url: '/add',
                data: {storeTime: this.storeTime, type: this.type},
            });
    },
    countdown() {
        if(this.totalTime >= 1){
            this.totalTime--;
        }else{
            this.totalTime = 0;
            this.saveTime()
            this.resetTimer()
            }
        }
    },

    computed: {
    minutes: function() {
        const minutes = Math.floor(this.totalTime / 60);
        return this.padTime(minutes);
    },
    seconds: function() {
        const seconds = this.totalTime - (this.minutes * 60);
        return this.padTime(seconds);
        }
    }
});

const app = new Vue({
    el: '#app',
});
