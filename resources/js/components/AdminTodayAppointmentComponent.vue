<template>
    <div class="container">
            <adminlistappointment-component :data="items.data"></adminlistappointment-component>
        <div class="row" style="margin-top:15px;">
            <div class="col-md-12">
                <pagination :data="items" @pagination-change-page="getData"></pagination> <!-- sayfalama için -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                items:{
                    data:[]
                }
            }
        },
        created(){
            this.getData();
        },
        mounted() {
            console.log("beni çağırdın...");
        },
        methods:{
            getData(page){
                console.log(page);
                if (typeof page === 'undefined')
                {
                    page = 1;
                }
                axios.get('http://rezervasyon-takip.det/api/admin/today-list/?page=${page}') //oluşturdupumuz api deki verilere eriştik bu şekilde
                    .then((res)=>{
                        this.items = res.data; //bu şekilde randevularımı sayfamıza çektik.
                    })
            }
        }
    }
</script>

<style scoped>

</style>
