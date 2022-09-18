<template>
    <!-- admin/index.blade.php deki tüm kodları buraya aldık-->
    <div class="container">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="waiting-tab" data-toggle="tab" href="#waiting" role="tab" aria-controls="waiting" aria-selected="true">Onay Bekleyen Randevular</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="today-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today" aria-selected="true">Günü Gelen Randevular</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false">Gelecek Randevular</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="last-tab" data-toggle="tab" href="#last" role="tab" aria-controls="last" aria-selected="false">Geçmiş Randevular</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="cancell-tab" data-toggle="tab" href="#cancell" role="tab" aria-controls="cancell" aria-selected="false">İptal Edilen Randevular</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="waiting" role="tabpanel" aria-labelledby="waiting-tab">
                <adminlistappointment-component @updateOkey="updateOkey" @updateCancel="updateCancel" :data="waiting.data"></adminlistappointment-component>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <pagination :data="waiting" @pagination-change-page="getData"></pagination> <!-- sayfalama için -->
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="today" role="tabpanel" aria-labelledby="today-tab">
                <adminlistappointment-component  @updateOkey="updateOkey"  @updateCancel="updateCancel" :data="today.data"></adminlistappointment-component>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <pagination :data="today" @pagination-change-page="getData"></pagination> <!-- sayfalama için -->
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                <adminlistappointment-component  @updateOkey="updateOkey" @updateCancel="updateCancel" :data="list.data"></adminlistappointment-component>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <pagination :data="list" @pagination-change-page="getData"></pagination> <!-- sayfalama için -->
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="last" role="tabpanel" aria-labelledby="last-tab">
                <adminlistappointment-component  @updateOkey="updateOkey" @updateCancel="updateCancel" :data="last.data"></adminlistappointment-component>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <pagination :data="last"  @pagination-change-page="getData"></pagination> <!-- sayfalama için -->
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="cancell" role="tabpanel" aria-labelledby="cancell-tab">
                <adminlistappointment-component  @updateOkey="updateOkey" @updateCancel="updateCancel" :data="cancell.data"></adminlistappointment-component>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <pagination :data="cancell" @pagination-change-page="getData"></pagination> <!-- sayfalama için -->
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import io from 'socket.io-client';
    var socket = io('http://localhost:3000/');

    export default {
        data(){
            return{
                waiting:{
                    data:[]
                },
                cancell:{
                    data:[]
                },
                list:{
                    data:[]
                },
                last:{
                    data:[]
                },
                today:{
                    data:[]
                }
            }
        },
        created(){
            this.getData();

            socket.on('admin_appointment_list', function(){
                console.log("veri geldi");
               this.getData();
            });
        },
        methods:{
            //sayfa yenilemeden onay iptal
            updateOkey(id){
                axios.post('http://rezervasyon-takip.det/api/admin/process',{
                    type:1,
                    id:id,
                })
                    .then((res)=>{
                        this.getData();
                    })
            },

            updateCancel(id){
                axios.post('http://rezervasyon-takip.det/api/admin/process',{
                    type:2,
                    id:id,
                })
                    .then((res)=>{
                        this.getData();
                    })
            },
            getData(page){
                console.log(page);
                if (typeof page === 'undefined')
                {
                    page = 1;
                }
                axios.get('http://rezervasyon-takip.det/api/admin/all/?page=${page}') //oluşturdupumuz api deki verilere eriştik bu şekilde
                    .then((res)=>{
                        this.waiting = res.data.waiting; //bu şekilde randevularımı sayfamıza çektik.
                        this.cancell = res.data.cancell;
                        this.list = res.data.list;
                        this.last = res.data.last;
                        this.today = res.data.today;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
