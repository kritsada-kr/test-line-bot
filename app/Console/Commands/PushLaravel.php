<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;

class PushLaravel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:message {userId} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test-push';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = $this->argument('message');
        $userId = $this->argument('userId');
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env('LINE_CHANNEL_ACCESS_TOKEN'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_CHANNEL_SECRET')]);
        $packageId = 11539;
        $stickerId = 52114110;
        $multiMessageBuilder = new MultiMessageBuilder();
        $multiMessageBuilder->add(new TextMessageBuilder($message));
        $multiMessageBuilder->add(new StickerMessageBuilder($packageId, $stickerId));
        $response = $bot->pushMessage($userId, $multiMessageBuilder);
        return Command::SUCCESS;
    }
}
