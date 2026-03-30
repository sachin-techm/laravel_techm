<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// class DataReleaseFakeCommand extends Command
return new class extends Command

{

   /**

    * The name and signature of the console command.

    *

    * @var string

    */

   protected $name = 'data_release:run';

   /**

    * The name and signature of the console command.

    *

    * @var string

    */
   
   protected $user = 'data_release:run';

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

    * @return mixed

    */

   public function handle()

   {

       (new \App\Http\Controllers\CronController)->createImportJsonRelease();

   }

};