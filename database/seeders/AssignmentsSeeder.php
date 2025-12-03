<?php

namespace Database\Seeders;

use App\Models\Assignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Assignment::create([
            'title' => 'Ontwikkel Nieuw E-commerce Platform',
            'short_description' => 'Op zoek naar een student om te helpen bij het bouwen van een nieuwe online winkel met moderne webtechnologieën.',
            'company_name' => 'Tech Oplossingen BV',
            'email' => 'hr@techoplossingen.nl',
            'phone_number' => '06-12345678'
        ]);

        Assignment::create([
            'title' => 'Mobiele App UI/UX Ontwerp',
            'short_description' => 'Op zoek naar een creatieve student om de gebruikersinterface en -ervaring voor onze aankomende mobiele applicatie te ontwerpen.',
            'company_name' => 'Creatieve Ontwerpen & Co.',
            'email' => 'carrieres@creatieveontwerpen.nl',
            'phone_number' => null
        ]);

        Assignment::create([
            'title' => 'Data Analyse Project',
            'short_description' => 'Stageplek voor een student om markttrends te analyseren en rapporten te genereren.',
            'company_name' => 'Data Inzichten VOF',
            'email' => 'dataproject@techoplossingen.nl',
            'phone_number' => '06-87654321'
        ]);

        Assignment::create([
            'title' => 'Content Creatie voor Social Media',
            'short_description' => 'We hebben een enthousiaste student nodig om boeiende content te creëren voor onze social media kanalen.',
            'company_name' => 'Sociaal Vaardig Agentschap',
            'email' => 'banen@sociaalvaardig.nl',
            'phone_number' => '06-11223344'
        ]);
    }
}
