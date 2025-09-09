<?php

namespace App\Console\Commands;

use App\Mail\CommunityNightNotification;
use App\Models\CommunityNight;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendCommunityNightReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-community-night-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stuurt herinneringen voor community avonden die over 3 dagen plaatsvinden.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $this->info('Controleren op aankomende community avonden...');


        $targetDate = Carbon::today()->addDays(3)->toDateString();

        $communityAvonden = CommunityNight::whereDate('start_time', $targetDate)
                                            ->get();

        if ($communityAvonden->isEmpty()) {
            $this->info('Geen community avonden gevonden die een herinnering nodig hebben voor ' . $targetDate . '.');
            return Command::SUCCESS;
        }

        $this->info(count($communityAvonden) . ' community avond(en) gevonden voor ' . $targetDate . '.');

        foreach ($communityAvonden as $avond) {
            
            $students = User::all();

            foreach ($students as $student) {
                try {
                    Mail::to($student->email)->send(new CommunityNightNotification($avond));
                    $this->info('E-mail verstuurd voor "' . $avond->title . '" naar ' . $student->email);
                } catch (\Exception $e) {
                    $this->error('Fout bij versturen van e-mail voor "' . $avond->title . '" naar ' . $student->email . ': ' . $e->getMessage());
                }
            }
        }

        $this->info('Herinneringen succesvol verstuurd.');
        return Command::SUCCESS;
    }
}
