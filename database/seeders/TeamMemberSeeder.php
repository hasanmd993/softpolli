<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $team = [
            [
                'name' => 'Azmir Hossain',
                'role' => 'Operations Manager',
                'image' => '/images/Azmir_Hossain_Gemini.png',
                'social' => [
                    'facebook' => 'https://facebook.com',
                    'linkedin' => 'https://linkedin.com',
                ],
                'sort_order' => 1,
            ],
            [
                'name' => 'Fahim Ahmed',
                'role' => 'Head of Supply Chain',
                'image' => '/images/Fahim_Ahmed_Gemini.png',
                'social' => [
                    'facebook' => 'https://facebook.com',
                    'linkedin' => 'https://linkedin.com',
                ],
                'sort_order' => 2,
            ],
            [
                'name' => 'Taukir Ahmed',
                'role' => 'Developer Team Lead',
                'image' => '/images/taukir_gemini.png',
                'social' => [
                    'facebook' => 'https://www.facebook.com/taukir.ahmed.30',
                    'linkedin' => 'https://www.linkedin.com/in/taukir-dev',
                    'website' => 'https://taukir-ahmed.netlify.app/',
                ],
                'sort_order' => 3,
            ],
            [
                'name' => 'Sabbir Ahmed',
                'role' => 'Senior Developer',
                'image' => '/images/sabbir.png',
                'social' => [
                    'facebook' => 'https://www.facebook.com/sabbirbd912',
                    'linkedin' => 'https://www.linkedin.com/in/sabbir-ahmed-dev/',
                    'website' => 'https://sabbir-web.netlify.app/',
                ],
                'sort_order' => 4,
            ],
        ];

        foreach ($team as $m) {
            TeamMember::updateOrCreate(['name' => $m['name']], $m);
        }
    }
}
