<?php namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\User;


class AddAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add-admin 
                                {name=R00t : The user fullname, by default \'R00t\'} 
                                {--M|email= : The user email} 
                                {--P|password=  : If empty can be auto-generated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user with the role set to admin';

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
        
        if( ($email = $this->option('email')) == null) {
            return $this->error("Please, must provide a email !");
        }
        
        // No password input ?
        if(($password = $this->option('password')) == null){
            // No password auto-generated ?
            if (!$this->confirm('Let system generate password for you ? ')) {
                $password = $this->secret('So, Please enter your new password (Hidden input) : ');
            } else {
                $password = str_random(16);
            }
            
            $this->info("Your account password => $password");
        }

        $password = app('hash')->make($password);
        $name = $this->argument('name');
        $role = 'admin';
        $created_at = date('Y-m-d H:i:s');
        
        if(User::create(compact('name', 'email', 'password','role','created_at'))){
            return $this->info("New admin ($name) created with $email");
        }
    }
}