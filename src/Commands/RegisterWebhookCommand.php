<?php

namespace Miqdadyyy\LaravelTelegramBot\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class RegisterWebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegrambot:webhook {--option=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register your webhook with unique url';

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
        $route = 'telegram-webhook/' . md5(env('APP_KEY'));
        $webhook_route = $this->setWebhook($route);
        $this->info($webhook_route);
    }

    private function setWebhook($route){
        $client = new Client();
        if($this->option('option') == "remove"){
            $req_url = config('laraveltelegrambot.base_url') .
                "bot" .
                config('laraveltelegrambot.api_key') .
                '/setWebhook?url=';
        } else {
            $req_url = config('laraveltelegrambot.base_url') .
                "bot" .
                config('laraveltelegrambot.api_key') .
                '/setWebhook?url=' .
                config('laraveltelegrambot.webhook_url', 'http://your-webhook-url/') .
                $route;
        }

        file_put_contents(__DIR__.'/../routes.php',
            "<?php \n\nRoute::post('$route', 'App\Http\Controllers\TelegramBot\WebhookUpdate@retrieveUpdate');\n");
        return $client->get($req_url)->getBody()->getContents();
    }
}
