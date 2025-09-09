<?php

namespace App\Console\Commands;

use App\Mail\EventNotification;
use App\Models\Events;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stuurt herinneringen voor evenementen die over 3 dagen plaatsvinden naar ingeschreven gebruikers.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->info('Controleren op aankomende evenementen voor herinneringen...');

        $targetDate = Carbon::today()->addDays(3)->toDateString();


        $events = Events::with('registrations.user')
                            ->whereDate('datum', $targetDate)
                            ->get();

        if ($events->isEmpty()) {
            $this->info('Geen evenementen gevonden die een herinnering nodig hebben voor ' . $targetDate . '.');
            return Command::SUCCESS;
        }

        $this->info($events->count() . ' evenement(en) gevonden voor ' . $targetDate . '.');

        foreach ($events as $event) {
            if ($event->registrations->isEmpty()) {
                $this->line('  -> Evenement "' . $event->titel . '" heeft geen inschrijvingen. Wordt overgeslagen.');
                continue;
            }

            $this->info('  -> Versturen van herinneringen voor "' . $event->titel . '" naar ' . $event->registrations->count() . ' inschrijving(en).');

            foreach ($event->registrations as $registration) {
                
                $recipientName = $registration->user ? $registration->user->name : $registration->naam;
                $recipientEmail = $registration->user ? $registration->user->email : $registration->email;

                if (empty($recipientEmail)) {
                    $this->error('      - FOUT: Geen e-mailadres gevonden voor inschrijving ID ' . $registration->id . '.');
                    continue;
                }

                try {
                    Mail::to($recipientEmail)->send(new EventNotification($event));
                    $this->line('      - Herinnering verstuurd naar ' . $recipientEmail . ' (' . $recipientName . ')');
                } catch (\Exception $e) {
                    $this->error('      - FOUT bij versturen naar ' . $recipientEmail . ': ' . $e->getMessage());
                }
            }
        }

        $this->info('Alle herinneringen zijn succesvol verwerkt.');
        return Command::SUCCESS;
    
        }
}
