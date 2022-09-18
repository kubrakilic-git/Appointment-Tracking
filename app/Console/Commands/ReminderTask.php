<?php

namespace App\Console\Commands;
use App\Models\Appointment;

use Illuminate\Console\Command;
use Mail;
class ReminderTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Reminder:Start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date("Y-m-d");
        $nextDate = date("Y-m-d",strtotime("+1 Day",time()));//böyle bir sonraki tarihi almış olduk
        $list = Appointment::whereIn('date',[$date,$nextDate])
        ->where('isActive',APPOINTMENT_SUCCESS)
        ->where('isSend',REMINDER_DEFAULT)
        ->get(); //appointment tablosundaki anın tarihi ve sonrasını almış olduk
        foreach ($list as $k => $v) {
            if($v['notification_type' == NOTIFICATION_EMAIL])
            { 
                $data = [
                    'name'=>$v['name'],
                    'email'=>$v['email'], 
                ];
                try{
                Mail::send('email',$data,function($message) use ($data){
                    $message->to($data['email'],$data['name'])->subject('Randevu Hatırlatms');
                    $message->form('randevutakipsistemi@gmail.com','Randevu Takip');
                });
                Appointment::where('id',$v['id'])->update(['isSend'=>REMINDER_SUCCESS]);

            }
            catch (\Exception $e)
            {
                dd($e->getMessage());
            }
            }

      
        }
    }
}
