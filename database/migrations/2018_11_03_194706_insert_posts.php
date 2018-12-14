<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Status;

class InsertPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(1==0){
            $output = new \Symfony\Component\Console\Output\ConsoleOutput();
            $start = microtime(true);
            for($i=0;$i<100;$i++){
                $status = new Status;
                $status->content       = "teststatus: ".$i;
                $status->poster       = 1;
                $status->save();
            }
            $time_elapsed_secs = microtime(true) - $start;
            $output->writeln('Time taken: '.$time_elapsed_secs);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
