<?php

namespace Database\Seeders;

use App\Models\Interview;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the admin user
        $admin = User::where('email', 'admin@hireflix.com')->first();

        if ($admin) {
            // Create a sample interview
            $interview = Interview::firstOrCreate(
                ['title' => 'Software Developer Interview'],
                [
                    'description' => 'This interview will assess your technical skills, problem-solving abilities, and communication skills for the Software Developer position.',
                    'created_by' => $admin->id,
                    'is_active' => true,
                ]
            );

            // Add questions to the interview
            $questions = [
                'Tell us about yourself and your experience in software development.',
                'What programming languages are you most comfortable with, and why?',
                'Describe a challenging project you worked on and how you overcame the difficulties.',
                'How do you approach debugging and troubleshooting code issues?',
                'What is your experience with version control systems like Git?',
                'How do you stay updated with the latest technologies and best practices?',
                'Describe a time when you had to work in a team and how you contributed to the project\'s success.',
                'What questions do you have about our company and this position?'
            ];

            foreach ($questions as $index => $questionText) {
                Question::firstOrCreate(
                    [
                        'interview_id' => $interview->id,
                        'order' => $index + 1,
                    ],
                    [
                        'question_text' => $questionText,
                    ]
                );
            }

            // Create another sample interview
            $interview2 = Interview::firstOrCreate(
                ['title' => 'Marketing Manager Interview'],
                [
                    'description' => 'This interview will evaluate your marketing expertise, leadership skills, and strategic thinking for the Marketing Manager role.',
                    'created_by' => $admin->id,
                    'is_active' => true,
                ]
            );

            $marketingQuestions = [
                'Tell us about your marketing background and key achievements.',
                'How do you develop and execute marketing strategies?',
                'Describe your experience with digital marketing channels.',
                'How do you measure the success of marketing campaigns?',
                'What is your approach to managing a marketing team?',
                'How do you stay current with marketing trends and technologies?',
                'Describe a successful marketing campaign you led and its results.',
                'How would you approach marketing for a new product launch?'
            ];

            foreach ($marketingQuestions as $index => $questionText) {
                Question::firstOrCreate(
                    [
                        'interview_id' => $interview2->id,
                        'order' => $index + 1,
                    ],
                    [
                        'question_text' => $questionText,
                    ]
                );
            }
        }
    }
}
