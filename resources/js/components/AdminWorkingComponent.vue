<template>
<div class="container">
    <div class="row">
        <div class="col-md-12">

        
            <adminworkingitem-component day="monday" @add="add" title="Pazartesi" :data="monday"></adminworkingitem-component>
            <adminworkingitem-component day="tuesday" @add="add" title="Salı" :data="tuesday"></adminworkingitem-component>
            <adminworkingitem-component day="wednesday" @add="add" title="Çarşamba" :data="wednesday"></adminworkingitem-component>
            <adminworkingitem-component day="thursday" @add="add" title="Perşembe" :data="thursday"></adminworkingitem-component>
            <adminworkingitem-component day="friday" @add="add" title="Cuma" :data="friday"></adminworkingitem-component>
            <adminworkingitem-component day="saturday" @add="add" title="Cumartesi" :data="saturday"></adminworkingitem-component>
            <adminworkingitem-component day="sunday" @add="add" title="Pazar" :data="sunday"></adminworkingitem-component>
            <button class="btn btn-success" @click="store">Kaydet</button>
        </div>

    </div>
</div>
</template>

<script>
import axios from 'axios';


export default {
    data(){
    return{
            monday:[],
            tuesday:[],
            wednesday:[],
            thursday:[],
            friday:[],
            saturday:[],
            sunday:[],  
          
        }
    },
    created(){
        axios.get('http://rezervasyon-takip.det/api/working-list').then((res)=>{
            this.monday = (typeof res.data.monday != 'undefined') ? res.data.monday : [],
            this.tuesday = (typeof res.data.tuesday != 'undefined') ? res.data.tuesday : [],
            this.wednesday = (typeof res.data.wednesday != 'undefined') ? res.data.wednesday : [],
            this.thursday = (typeof res.data.thursday != 'undefined') ? res.data.thursday : [],
            this.friday = (typeof res.data.friday != 'undefined') ? res.data.friday : [],
            this.saturday = (typeof res.data.saturday != 'undefined') ? res.data.saturday : [],
            this.sunday = (typeof res.data.sunday != 'undefined') ? res.data.sunday : []
        })
    },
    methods:{
        add:function(data){
            this[data.day].push(data.text);
        },
        store:function(){
            axios.post('http://rezervasyon-takip.det/api/working-store',{
                monday:this.monday,
                tuesday:this.tuesday,
                wednesday:this.wednesday,
                thursday:this.thursday,
                friday:this.friday,
                saturday:this.saturday,
                sunday:this.sunday,
            })
            .then((res)=>{
                console.log(res);
            })
        }
    }
}
</script>

