<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Technology',
            'Laravel',
            'Web Development',
            'Programming',
            'Open Source',
            'JavaScript',
            'Python',
            'Machine Learning',
            'AI',
            'Cyber Security',
            'Design',
            'UI/UX',
            'Mobile Apps',
            'Cloud Computing',
            'Database',
            'Lifestyle',
            'Health',
            'Fitness',
            'Travel',
            'Food',
            'Education',
            'Career',
            'Entrepreneurship',
            'Marketing',
            'Finance',
            'Cryptocurrency',
            'Blockchain',
            'E-commerce',
            'Social Media',
            'SEO',
            'Photography',
            'Gaming',
            'Music',
            'Movies',
            'Art',
            'Science',
            'History',
            'Nature',
            'Environment',
            'Sustainability',
            'Business Strategy',
            'Startup',
            'Productivity',
            'Self Improvement',
            'Motivation',
            'Remote Work',
            'Digital Nomad',
            'Gadgets',
            'Software',
            'Hardware'
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }
    }
}
