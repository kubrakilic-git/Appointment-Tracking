<template>
    <div>
        <div v-if="completeForm">
            <div class="container">
                <div class="main">
                    <h2>Randevu Takip Sistemi</h2>
                    <h3>Randevu Oluşturmak İçin Bilgileri Doğru Giriniz</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li class="errors" v-for="i in errors">
                                {{ i }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="name" placeholder="Ad Soyad">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" v-mask="'##-###-###-##-##'" class="form-control" v-model="phone" placeholder="Telefon">
                        </div>
                    </div>
                    
               
                      
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="date" :min="minDate" @change="selectDate" v-model="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="select-time-ul">
                            <li v-for="item in workingHours" class="select-time" >
                                <input v-if="item.isActive" type="radio"  v-model="workingHour" v-bind:value="item.id">
                                <span>{{ item.hours }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea v-model="text" class="form-control" id="" cols="30" rows="10" placeholder="Eklemek İstediğiniz Notunuzu Giriniz"></textarea>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Sms</label>
                                    <input type="radio" v-model="notification_type" value="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="radio" v-model="notification_type" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-12" style="text-align:center;">
                        <button v-on:click="store" class="btn btn-success">Randevu Oluştur</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!completeForm">
            <div class="complete-form">
                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                <span>Randevunuz Başarı İle Alınmıştır.</span>
            </div>
        </div>
    </div>


</template>

<script>
    import io from 'socket.io-client';
    var socket = io('http://localhost:3000/');
    export default {
        name: "RandevuFormComponent",
        data(){
          return{
              completeForm:true,
              errors:[],
              workingHour:0,
              name:null,
              email:null,
              phone:null,
              text:null,
              minDate:new Date().toISOString().slice(0,10),
              date:new Date().toISOString().slice(0,10), //tarihi stringe çevirip slice ile 10 karakterlik kısmını aldık
              workingHours:[]
          }
        },
        created(){
            socket.emit('hello');
        },
        mounted() {
            axios.get('http://rezervasyon-takip.det/api/working-hours').then((res)=>{
                this.workingHours = res.data;
            })
        },
        methods:{
            store:function(){
                if (this.name && this.email && this.validEmail(this.email) && this.phone && this.workingHour!=0)
                {
                    //bu şekilde veritabanına ekledik.
                    axios.post('http://rezervasyon-takip.det/api/appointment-store',{
                        fullname:this.name,
                        phone:this.phone,
                        email:this.email,
                        date:this.date,
                        workingHour:this.workingHour,
                    }).then((res)=>{
                        if (res.status)
                        {
                            socket.emit('new_appointment_create');
                            this.completeForm = false;
                        }
                    })
                 }
                this.errors = [];
                if (!this.name) {
                    this.errors.push('İsim Soyisim Girilmelidir.')
                }
                if (!this.email || !this.validEmail(this.email)) {
                    this.errors.push('Email Girilmelidir ve Formatı Doğru Olmalıdır.')
                }
                if (!this.phone) {
                    this.errors.push('Telefon Numarası Girilmelidir.')
                }
                if (!this.workingHour) {
                    this.errors.push('Çalışma Saati Seçilmelidir.')
                }
            },
            selectDate:function () {
                axios.get('http://rezervasyon-takip.det/api/working-hours/${this.date}').then((res)=>{
                    console.log(res.data);
                    this.workingHours = res.data;
                })
            },
            validEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        }
    }
</script>

<style scoped>

</style>
