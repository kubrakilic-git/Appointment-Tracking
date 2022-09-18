<template>
    <div class="row">
        <div v-for="item in data"  class="col-md-4 card-style">
            <div class="card appointment-card">
                <span class="appointment-number">  Randevu
                    <span class="new-appointment"  v-if="item.isActive == 0">Yeni</span>
                    <span class="new-appointment waiting-new"  v-if="item.isActive == 1">Onaylı</span>
                    <span class="new-appointment cancel-new"  v-if="item.isActive == 2">İptal Edilen</span>
                </span>
                <div class="appointment-detail">
                    <span>{{item.fullname}}</span>
                    <span><i class="fa fa-date"></i>{{item.date}}</span>
                    <span>{{item.working}}</span>

                </div>
                <div class="appintment-buttons" v-if="!item.isActive">
                    <button @click="appointmentOkey(item.id)">Onayla</button>
                    <button @click="appointmentCancel(item.id)">İptal Et</button>
                </div>
                <!-- onaylama işlemleri -->
            </div>
        </div>

        
    </div>

</template>

<script>
    export default {
        props:['data'], //bu şekilde datayı alıyoruz
      
        created(){
            console.log('liste cagrıldı');
        },
        //onaylama işlemleri
        methods:{
            appointmentOkey:function(id){
                this.$emit('updateOkey',id)
            },
            appointmentCancel:function(id){
                this.$emit('updateCancel',id)
            },
           
        }
    }
</script>

<style scoped>

</style>
