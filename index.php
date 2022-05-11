<html>
  <head>
    <title>TOOLS SPAM USELESS by @bknsr</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
    <script src="https://unpkg.com/vue-router@2.0.0"></script>
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    />
    <style>
        samp {
            white-space: pre-line;
        }
    </style>
  </head>
  <body>
    <div id="app" class="container-fluid justify-content-center">
        <h4 class="text-center mt-3 mb-4">FREE SPAM TLP dan SMS</h4> 
        <p v-if="errors.length">
          <b>Info:</b>
          <ul>
            <li v-for="error in errors">{{ error }}</li>
          </ul>
        </p>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="tipe">Tipe</label>
                    <select id="tipe" class="form-control" v-model="type">
                        <option v-for="v in tipe" :value="v.value">
                            {{ v.text }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col" v-if="!!type">
                <div class="form-group">
                    <label for="no_hp">No Hp</label>
                    <input id="no_hp" class="form-control" type="number" placeholder="822xxxxxxxx" v-model="form.no_hp">
                </div>
            </div>
        </div>

        <div class="row" v-if="!!form.no_hp">
            <div class="col">
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input id="jumlah" class="form-control" type="number" placeholder="2" v-model="form.jumlah">
                </div>
            </div>
            <div class="col" v-if="!!withDelay">
                <div class="form-group">
                    <label for="delay">Delay</label>
                    <select id="delay" class="form-control" v-model="form.delay">
                        <option v-for="v in delay" :value="v.value">
                            {{ v.text }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <button
            class="btn btn-outline-info"
            v-if="!!form.no_hp && !!form.jumlah || !!form.delay"
            @click="submit"
        >Gass Spam!</button>

        <div class="row" v-if="!!output">
            <div class="col mt-3">
                <p class="font-weight-bold">LOG:</p><br/>
                <samp>{{ output }}</samp>
            </div>
        </div>

        <div class="wrapper">
          <footer
            style="
              background-color: rgb(236, 236, 236);
              position: fixed;
              width: 100%;
              font-size: 80%;
              margin-top: 5em;
              padding-top: 5px;
              padding-bottom: 5px;
              bottom: 0;
            "
          >
            <div class="container">
              <i>© {{ date }} - TOOLS SPAM USELESS by @bknsr</i>
            </div>
          </footer>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js" integrity="sha512-odNmoc1XJy5x1TMVMdC7EMs3IVdItLPlCeL5vSUPN2llYKMJ2eByTTAIiiuqLg+GdNr9hF6z81p27DArRFKT7A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/eruda"></script>
    <script>
        // eruda.init(); // uncomment for open the console in mobile browser
    </script>
    <script>
      var app = new Vue({
        el: '#app',
        data() {
            return {
                date: new Date().getFullYear(),
                time: '',
                form: {
                    no_hp: null,
                    jumlah: null,
                    delay: null
                },
                tipe: [
                    { text: 'Call', value: 'call' },
                    { text: 'Sms', value: 'sms' }
                ],
                delay: [
                    { text: '2 Detik', value: '2000' },
                    { text: '5 Detik', value: '5000' },
                    { text: '10 Detik', value: '10000' },
                    { text: '15 Detik (recomended)', value: '15000' }
                ],
                type: null,
                withDelay: false,
                errors: [],
                output: '',
                url: {
                    sms: 'https://amfcode.my.id/api/spamsms?phone=',
                    call: 'https://id.jagreward.com/member/verify-mobile/'
                },
                headers: {
                    'Host': 'id.jagreward.com',
                    'Connection': 'keep-alive',
                    'User-Agent': 'Mozilla/5.0 (Linux; Android 8.1.0; vivo 1724) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.73 Mobile Safari/537.36'
                }
            }
        },
        created() {
            axios.interceptors.request.use((config) => {
                this.output += `\n[${this.time}] requesting ...`
                return config
            }, (error) => {
                this.output += `\n[${this.time}] request failed`
                return Promise.reject(error)
            })

            axios.interceptors.response.use((response) => {
                this.output += `\n[${this.time}] waiting response ...`
                this.output += `\n[${this.time}] spam success`
                this.output += `\n[${this.time}] Done`
                return response
            }, (error) => {
                this.output += `\n[${this.time}] waiting response ...`
                this.output += `\n[${this.time}] spam success`
                this.output += `\n[${this.time}] Done`
                return Promise.reject(error)
            })
        },
        mounted() {
            const times = window.setTimeout(this.getTime, 1000)
            this.$on('hook:destroyed', () => window.clearTimeout(times))
        },
        methods: {
            async submit() {
                this.output = ''
                this.errors = []

                if (this.form.no_hp && this.form.jumlah || this.form.delay) {
                    switch(this.type) {
                        case 'sms':
                            if (!!this.withDelay) {
                                for (i = 0; i < this.form.jumlah; i++) {
                                    await this.delay_(+this.form.delay)
                                    this.sms()
                                }
                            }
                            this.sms()
                            break;
                        case 'call':
                            if (!!this.withDelay) {
                                for (i = 0; i < this.form.jumlah; i++) {
                                    await this.delay_(+this.form.delay)
                                    this.call()
                                }
                            }
                            this.call()
                            break;
                        default:
                            break       
                    }
                }

                let form = _.omit(this.form, 'delay')
                Object.keys(form).map(keys => {
                    if (!this.form[keys]) {
                        this.errors.push(`${keys} is required`)
                    }
                })
            },
            sms() {
                axios.get(this.url.sms + this.form.no_hp)
                    .then(({ data }) => {
                        console.log(data)
                    }).catch( e => console.error)
            },
            call() {
                axios.post(this.url.call + this.form.no_hp, {
                    method: "CALL",
                    countryCode: "id",
                }, { headers: {...this.headers} })
                    .then(({ data }) => {
                        console.log(data)
                    }).catch( e => console.error)
            },
            delay_(ms) {
                return new Promise(resolve => setTimeout(resolve, ms))
            },
            getTime() {
                this.time = `${new Date().getDate() < 10 ? `0${new Date().getDate()}` : new Date().getDate()}/${new Date().getMonth() < 10 ? `0${new Date().getMonth()}` : new Date().getMonth()}, ${new Date().getHours() < 10 ? `0${new Date().getHours()}` : new Date().getHours()}:${new Date().getMinutes() < 10 ? `0${new Date().getMinutes()}` : new Date().getMinutes()}`
                window.setTimeout(this.getTime, 1000)
            }
        },
        watch: {
            'form.jumlah': function(v, _) {
                if (v >= 2) {
                    this.withDelay = !0
                } else {
                    this.withDelay = !!0
                }
            }
        }
      })
    </script>
  </body>
</html>