/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('leader-boards',{
	template:
        `<div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"
                v-for="(leaderBoard, index) in leaderBoards"
                :leaderBoard='leaderBoard'
                :key='index'>
                    <p>Place: {{index+1}} {{leaderBoard.name}}</p> <small>{{leaderBoard.duration}} Mins of being focused</small>
                </li>
            </ul>
        </div>`,
    data:function(){
        return{
            leaderBoards: [],
        }
    },
    methods: {
        showLeaderBoards(){
            var self = this;
            axios({
                method: 'get',
                url: '/showLeaderBoards'
            })
            .then(response =>{
                self.leaderBoards = response.data;
                console.log(response.data);
            })
            .catch(error =>{
                console.log(error)
            });
        },
    },
	mounted(){
        this.showLeaderBoards();
	}
});

Vue.component('my-progress-bar',{
	template:
        `<div class="card-body">
            <h4 class="mr-1 mb-1">Lvl:{{profileInfo[0]}}</h4>
            <h5>Total Exp: {{Math.floor(profileInfo[2]*12.47)}}</h5>
            <div class="progress">
            	<div
            		class="progress-bar"
            		role="progressbar"
            		:style="'width: ' + profileInfo[1]+'%;'"
            		:aria-valuenow="profileInfo[1]"
            		aria-valuemin="0"
            		aria-valuemax="100">
            		{{ profileInfo[1] }}%
            	</div>
            </div>
        </div>`,
    data:function(){
        return{
            profileInfo: [],
        }
    },
    methods: {
        showExp(){
            var self = this;
            axios({
                method: 'get',
                url: '/showExp'
            })
            .then(response =>{
                self.profileInfo = response.data;
                // console.log(response);
            })
            .catch(error =>{
                console.log(error)
            });
        },
    },
	created(){
        this.showExp();
	}
});

Vue.component('quote', {
    template:`
    <p v-bind="quotes">
        <i>"{{quotes.en}}"</i><br>-{{quotes.author}}
    </p>
    `,
    data: function(){
        return{
            quotes: [],
            displayedQuote:'',
        }
    },
    methods: {
        appendWords: function() {
            const it = this.quotes[Symbol.iterator](); // convenient for yeilding values
            const int = setInterval(() => { // time interval
                const next = it.next(); // next value
                if (!next.done) { // done = true when the end of array reached
                    this.displayedQuote += ' ' + next.value; // concatenate word to the string
                } else {
                    clearInterval(int); // when done - clear interval
                }
            }, 1000) // interval duration, 1s
        }
    },
    mounted() {
        var self = this;
        axios.get('https://programming-quotes-api.herokuapp.com/quotes/random')
        .then(response =>{
            self.quotes = response.data;
            // console.log(response.data[450].author+" "+response.data[450].en)
        })
        .catch(error =>{
            console.log(error)
        });
        this.appendWords();

    },
});

Vue.component('log', {
    template:`
    <div class="">
        <my-progress-bar></my-progress-bar><br>
        <div class="card-header">Activity Log: Your Last 5 Timers</div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item" v-for="(log, index) in logs"
                :log="log"
                :key="index">
                Time: {{log.duration}} mins, Type: {{log.type}}<br>
                    <small>{{log.created_at}}</small>
                </li>
            </ul>
        </div>
    </div>
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
                method: 'post',
                url: '/'
            })
            .then(response =>{
                self.logs = response.data;
            })
            .catch(error =>{
                console.log(error)
            });
        },
    },
    mounted() {
        this.showLog();
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
                        <option value="studying">Study</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    `,
    data: function() {
        return{
    timer: null,
    totalTime: (25 * 60),
    resetButton: true,
    title: "Let the countdown begin!!",
    storeTime: null,
    type: "unset",
        }
    },

    methods: {
    startTimer() {
        this.timer = setInterval(() => this.countdown(), 10);
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
        this.totalTime = (this.totalTime + 5 * 60);
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
