<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Support\Facades\Notification;

class SendScheduledAnnouncements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-scheduled-announcements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        $announcements = Announcement::where('scheduled_at', '<=', $now)
            ->whereDoesntHave('notifications') 
            ->get();

        $students = User::where('role', 'Student')->get();

        foreach ($announcements as $announcement) {
            Notification::send($students, new AnnouncementNotification($announcement)); 
        }
    }
}
