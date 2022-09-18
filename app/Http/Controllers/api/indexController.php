<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\WorkingHours;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class indexController extends Controller
{
    public function getWorkingHours($date = '')
    {
        $date = ($date == '') ? date("Y-m-d") : $date;
        $day = date("l",strtotime($date));
        $returnArray = [];
        $hours = WorkingHours::where('day',$day)->get();
        foreach ($hours as $k => $v)
        {
            //saatin dolumu boşmu oldugunu kontrol ediyoruz
            $control = Appointment::where('date', $date)
            ->where('WorkingHour',$v['id'])
            ->where(function($control){
                $control->orWhere('isActive', APPOINTMENT_DEFAULT);
                $control->orWhere('isActive', APPOINTMENT_SUCCESS);
            })
            ->count();
            //11.00 - 12.00 (bu formatta almak için)
            $exp = explode('-',$v['hours']);
            //şaunki saati alalım
            $nowTime = date("H.i"); // 11:52
            // alttaki sorguya gelerek
            $v['isActive'] = ($control == 0 and $exp[0] > $nowTime) ? true : false;
            $returnArray[] = $v;
        }
        return response()->json($returnArray);
    }

    public function appointmentStore(Request $request)
    {
        $returnArray = []; //geri dönüş arrayı
        $returnArray['status'] = "false"; //default değer
        $all = $request->except('_token'); //bu şekilde token hariç tüm verilerimizi alıyoruz.
        $control = Appointment::where('date',$all['date'])->where('workingHour',$all['workingHour'])->count();
        //üsteki kod seçilen tarihle ve şeçilen çalışma saatinde herhangi bir randevu var mı onun kontrolu yapılıyor
        if ($control != 0) //hani herhangi bir randevı varsa
        {
            $returnArray['message']= "Bu Randevu Tarihi Doludur";
            return response()->json($returnArray);//json olarak return arrayi geri döndürsün.
        }

        $create = Appointment::create($all); //randevuları oluşturuyoruz
        if ($create) //eğer randevu oluştuysa
        {
            $returnArray['status'] = true;
            $returnArray['message'] = "Randevunuz Başarı İle Alındı";
        }
        else
        {
            $returnArray['message'] = "Veri Eklenemedi Bizimle İletişime Geçiniz";
        }
        return response()->json($returnArray);
    }

    public function getWorkingStore(Request $request)
    {
        $all = $request->except('_token'); //token hariç tüm verileri al
        // WorkingHours::query()->delete();
        foreach($all as $k => $v){
            $day = $k;
            foreach($v as $key=>$value)
            {
                WorkingHours::create([
                    'day' =>$k,
                    'hours'=>$value
                ]);
            }
        }
        return response()->json($all);
    }

    public function getWorkingList()
    {
        $returnArray = []; //geri dönüs arrayı
        $data = WorkingHours::all();
        foreach($data as $k => $v){
            $returnArray[$v['day']][]=$v['hours'];
        }

        return response()->json($returnArray);
    }
}
