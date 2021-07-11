<?php

namespace App\Console\Commands;

use App\Models\Event;
use Carbon\Carbon;
use \App\Models\User;
use Illuminate\Console\Command;
use OneSignal;

class NotifyUserAboutComingEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NotifyUserAboutComingEvent';

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
        Carbon::setLocale('uk');
        $from = Carbon::now()->addDay(1);
        $to = Carbon::now()->addDay(2);
        $events = Event::query()->whereHas('user', function ($query) {
            $query->whereNotNull('open_signal_token');
        })->whereBetween('start_date', [$from, $to])->with(['user'])->get();

        foreach ($events as $event) {
            $message = "Повідомляємо що ".Carbon::parse($event->start_date)->translatedFormat(' j F Y ').
                ' настане подія '.$event->name;
            OneSignal::sendNotificationToUser(
                $message,
                $event->user->open_signal_token,
            );
        }

    }
}
