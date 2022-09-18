<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\WorkingHours;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function all()
    {
        /*şimdi burada process fonksiyonu hariç tüm fonksiyonları birleştireceğiz*/
        $returnArray =[];
        /*waitin onay bekleyen*/
        $returnArray['waiting'] = Appointment::where('isActive',0)->orderBy('workingHour','asc')->orderBy('created_at','desc')->paginate(12);//randevuları oluşturulma tarihine göre çekiyoruz
        $returnArray['waiting']->getCollection()->transform(function ($value){
            $value['working'] = WorkingHours::getString($value['workingHour']);
            return $value;
        });
        /*cance iptal edilen*/
        $returnArray['cancell'] = Appointment::where('isActive',2)->orderBy('workingHour','asc')->orderBy('created_at','desc')->paginate(12);//randevuları oluşturulma tarihine göre çekiyoruz
        $returnArray['cancell']->getCollection()->transform(function ($value){
            $value['working'] = WorkingHours::getString($value['workingHour']);
            return $value;
        });
        /*list gelecek */
        $returnArray['list'] = Appointment::where('isActive',1)->where('date','>',date("Y-m-d"))->orderBy('workingHour','asc')->orderBy('created_at','desc')->paginate(12);//randevuları oluşturulma tarihine göre çekiyoruz
        $returnArray['list']->getCollection()->transform(function ($value){
            $value['working'] = WorkingHours::getString($value['workingHour']);
            return $value;
        });
        /*last geçmiş*/
        $returnArray['last'] = Appointment::where('date','<',date("Y-m-d"))->orderBy('workingHour','asc')->orderBy('created_at','desc')->paginate(12);//randevuları oluşturulma tarihine göre çekiyoruz
        $returnArray['last']->getCollection()->transform(function ($value){
            $value['working'] = WorkingHours::getString($value['workingHour']);
            return $value;
        });
        /*today günü gelen*/
        $returnArray['today'] = Appointment::where('isActive',1)->where('date',date("Y-m-d"))->orderBy('workingHour','asc')->orderBy('created_at','desc')->paginate(12);//randevuları oluşturulma tarihine göre çekiyoruz
        $returnArray['today']->getCollection()->transform(function ($value){
            $value['working'] = WorkingHours::getString($value['workingHour']);
            return $value;
        });

        return response()->json($returnArray);//json formatında döndürdük
    }

//    public function getList()
//    {
//        //gelecek randevular
//        $data = Appointment::where('isActive',1)->where('date','>',date("Y-m-d"))->orderBy('workingHour','asc')->orderBy('created_at','desc')->paginate(12);//randevuları oluşturulma tarihine göre çekiyoruz
//        $data->getCollection()->transform(function ($value){
//            $value['working'] = WorkingHours::getString($value['workingHour']);
//            return $value;
//        });
//        return response()->json($data); //json formatında döndürdük
//    }
//
//    //geçmiş randevular için
//    public function getLastList()
//    {
//        $data = Appointment::where('date','<',date("Y-m-d"))->orderBy('workingHour','asc')->orderBy('created_at','desc')->paginate(12);//randevuları oluşturulma tarihine göre çekiyoruz
//        $data->getCollection()->transform(function ($value){
//            $value['working'] = WorkingHours::getString($value['workingHour']);
//            return $value;
//        });
//        return response()->json($data); //json formatında döndürdük
//    }
//
//
//    public function getTodayList()
//    {
//        //where içinde bugunun tarihini sorguladık
//        $data = Appointment::where('isActive',1)->where('date',date("Y-m-d"))->orderBy('workingHour','asc')->orderBy('created_at','desc')->paginate(12);//randevuları oluşturulma tarihine göre çekiyoruz
//        $data->getCollection()->transform(function ($value){
//            $value['working'] = WorkingHours::getString($value['workingHour']);
//            return $value;
//        });
//        return response()->json($data); //json formatında döndürdük
//    }
//
//    public function getWaitingList()
//    {
//        //burada önemli olan koşul isActive 0 olmasıdır yani yeni
//        $data = Appointment::where('isActive',0)->orderBy('workingHour','asc')->orderBy('created_at','desc')->paginate(12);//randevuları oluşturulma tarihine göre çekiyoruz
//        $data->getCollection()->transform(function ($value){
//            $value['working'] = WorkingHours::getString($value['workingHour']);
//            return $value;
//        });
//        return response()->json($data); //json formatında döndürdük
//    }

    //onaylama iptal etme
    public function process(Request $request){
         $all = $request->except('_token');
         Appointment::where('id',$all['id'])->update(['isActive'=>$all['type']]);
         return response()->json(['status'=>true]);

         //şimdi bunu adminlistappointment de kullanacağız.
    }

//    public function getCancelList()
//    {
//        //burada önemli olan koşul isActive 0 olmasıdır yani yeni
//        $data = Appointment::where('isActive',2)->orderBy('workingHour','asc')->orderBy('created_at','desc')->paginate(12);//randevuları oluşturulma tarihine göre çekiyoruz
//        $data->getCollection()->transform(function ($value){
//            $value['working'] = WorkingHours::getString($value['workingHour']);
//            return $value;
//        });
//        return response()->json($data); //json formatında döndürdük
//    }
}
