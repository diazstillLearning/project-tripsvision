<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;

class DestinationReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample destinations
        $destinations = [
            [
                'name' => 'Danau Toba',
                'location' => 'Kabupaten Toba Samosir, Sumatera Utara',
                'price' => 10000.00,
                'price_range' => 'Rp 5.000 - Rp 15.000',
                'rating' => 4.50,
                'description' => 'Danau Toba adalah danau vulkanik terbesar di dunia yang terletak di Sumatera Utara, Indonesia. Danau ini terbentuk dari letusan gunung berapi super yang terjadi sekitar 70.000 tahun yang lalu. Dengan luas sekitar 1.145 km², Danau Toba menjadi salah satu destinasi wisata paling populer di Indonesia.',
                'category' => 'nature',
                'image_url' => 'destinations/danau-toba-main.jpg',
                'image_url2' => 'destinations/danau-toba-2.jpg',
                'image_url3' => 'destinations/danau-toba-3.jpg',
                'latitude' => 2.6845,
                'longitude' => 98.8756,
                'total_reviews' => 0,
                'average_rating' => 0.00,
                'slug' => 'danau-toba',
                'highlights' => 'Danau vulkanik terbesar di dunia|Pulau Samosir dengan budaya Batak yang unik|Pemandangan alam yang spektakuler|Air terjun Sipiso-piso yang menakjubkan|Desa wisata tradisional',
                'facilities' => [
                    'accommodation',
                    'restaurant',
                    'transportation',
                    'water_activities',
                    'shopping',
                    'medical',
                    'parking',
                    'wifi'
                ],
                'gallery' => [
                    'destinations/danau-toba-gallery-1.jpg',
                    'destinations/danau-toba-gallery-2.jpg',
                    'destinations/danau-toba-gallery-3.jpg'
                ],
                'is_featured' => true,
                'is_active' => true,
                'opening_hours' => '24 hours',
                'best_time_to_visit' => 'April - September (dry season)',
                'contact_info' => '+62 625 123456'
            ],
            [
                'name' => 'Gunung Tangkuban Perahu',
                'location' => 'Kabupaten Bandung Barat, Jawa Barat',
                'price' => 25000.00,
                'price_range' => 'Rp 20.000 - Rp 30.000',
                'rating' => 4.20,
                'description' => 'Gunung Tangkuban Perahu adalah gunung berapi aktif yang terletak di Jawa Barat, Indonesia. Gunung ini memiliki bentuk yang unik menyerupai perahu terbalik, sesuai dengan namanya. Tangkuban Perahu menawarkan pemandangan kawah yang menakjubkan dan udara sejuk pegunungan.',
                'category' => 'nature',
                'image_url' => 'destinations/tangkuban-perahu-main.jpg',
                'image_url2' => 'destinations/tangkuban-perahu-2.jpg',
                'image_url3' => 'destinations/tangkuban-perahu-3.jpg',
                'latitude' => -6.7598,
                'longitude' => 107.6098,
                'total_reviews' => 0,
                'average_rating' => 0.00,
                'slug' => 'tangkuban-perahu',
                'highlights' => 'Gunung berapi aktif dengan bentuk unik|Kawah Ratu yang spektakuler|Udara sejuk pegunungan|Pemandangan panorama Bandung|Hot springs alami',
                'facilities' => [
                    'restaurant',
                    'transportation',
                    'shopping',
                    'medical',
                    'parking',
                    'guide'
                ],
                'gallery' => [
                    'destinations/tangkuban-perahu-gallery-1.jpg',
                    'destinations/tangkuban-perahu-gallery-2.jpg'
                ],
                'is_featured' => true,
                'is_active' => true,
                'opening_hours' => '08:00 - 17:00',
                'best_time_to_visit' => 'Year round, avoid rainy season',
                'contact_info' => '+62 22 123456'
            ],
            [
                'name' => 'Candi Borobudur',
                'location' => 'Magelang, Jawa Tengah',
                'price' => 50000.00,
                'price_range' => 'Rp 40.000 - Rp 60.000',
                'rating' => 4.70,
                'description' => 'Candi Borobudur adalah candi Buddha terbesar di dunia yang terletak di Magelang, Jawa Tengah. Dibangun pada abad ke-8 dan ke-9, candi ini merupakan warisan dunia UNESCO yang menampilkan arsitektur dan relief yang luar biasa.',
                'category' => 'culture',
                'image_url' => 'destinations/borobudur-main.jpg',
                'image_url2' => 'destinations/borobudur-2.jpg',
                'image_url3' => 'destinations/borobudur-3.jpg',
                'latitude' => -7.6079,
                'longitude' => 110.2038,
                'total_reviews' => 0,
                'average_rating' => 0.00,
                'slug' => 'candi-borobudur',
                'highlights' => 'Candi Buddha terbesar di dunia|Warisan Dunia UNESCO|Arsitektur abad ke-8|Sunrise viewing yang menakjubkan|Relief Buddhist yang indah',
                'facilities' => [
                    'accommodation',
                    'restaurant',
                    'transportation',
                    'shopping',
                    'medical',
                    'parking',
                    'guide',
                    'wifi'
                ],
                'gallery' => [
                    'destinations/borobudur-gallery-1.jpg',
                    'destinations/borobudur-gallery-2.jpg'
                ],
                'is_featured' => true,
                'is_active' => true,
                'opening_hours' => '06:00 - 17:00',
                'best_time_to_visit' => 'April - October (dry season)',
                'contact_info' => '+62 293 123456'
            ],
            [
                'name' => 'Raja Ampat',
                'location' => 'Kabupaten Raja Ampat, Papua Barat',
                'price' => 500000.00,
                'price_range' => 'Rp 300.000 - Rp 1.000.000',
                'rating' => 4.80,
                'description' => 'Raja Ampat adalah kepulauan yang terletak di ujung barat laut Papua, Indonesia. Dikenal sebagai "The Crown Jewel of Marine Biodiversity", Raja Ampat menawarkan keanekaragaman hayati laut yang luar biasa dengan terumbu karang dan ikan yang beragam.',
                'category' => 'adventure',
                'image_url' => 'destinations/raja-ampat-main.jpg',
                'image_url2' => 'destinations/raja-ampat-2.jpg',
                'image_url3' => 'destinations/raja-ampat-3.jpg',
                'latitude' => -0.2312,
                'longitude' => 130.5256,
                'total_reviews' => 0,
                'average_rating' => 0.00,
                'slug' => 'raja-ampat',
                'highlights' => 'Keanekaragaman hayati laut terkaya di dunia|Diving dan snorkeling terbaik|Pemandangan karst yang menakjubkan|Budaya Papua yang unik|Bird watching paradise',
                'facilities' => [
                    'accommodation',
                    'restaurant',
                    'transportation',
                    'water_activities',
                    'guide'
                ],
                'gallery' => [
                    'destinations/raja-ampat-gallery-1.jpg'
                ],
                'is_featured' => true,
                'is_active' => true,
                'opening_hours' => '24 hours',
                'best_time_to_visit' => 'October - April',
                'contact_info' => '+62 951 123456'
            ]
        ];

        foreach ($destinations as $destinationData) {
            Destination::create($destinationData);
        }

        // Update existing users or create new ones if they don't exist
        $users = [
            [
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role' => 'member'
            ],
            [
                'username' => 'sarah_wilson',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
                'role' => 'member'
            ],
            [
                'username' => 'mike_chen',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
                'role' => 'member'
            ]
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Get created destinations and users
        $danauToba = Destination::where('slug', 'danau-toba')->first();
        $tangkubanPerahu = Destination::where('slug', 'tangkuban-perahu')->first();
        $borobudur = Destination::where('slug', 'candi-borobudur')->first();
        $rajaAmpat = Destination::where('slug', 'raja-ampat')->first();

        $johnDoe = User::where('email', 'john@example.com')->first();
        $sarahWilson = User::where('email', 'sarah@example.com')->first();
        $mikeChen = User::where('email', 'mike@example.com')->first();

        // Create sample reviews
        $reviews = [
            // Danau Toba Reviews
            [
                'user_id' => $johnDoe->id,
                'destination_id' => $danauToba->id_destinations,
                'rating' => 5,
                'comment' => 'Amazing place! The view is absolutely breathtaking. Danau Toba is definitely a must-visit destination in Indonesia. The water is crystal clear and the surrounding mountains create a perfect scenic backdrop. Highly recommended for anyone looking for a peaceful getaway.',
                'status' => 'approved',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2)
            ],
            [
                'user_id' => $sarahWilson->id,
                'destination_id' => $danauToba->id_destinations,
                'rating' => 4,
                'comment' => 'Great destination for family vacation. The culture at Samosir Island is fascinating and the local people are very friendly. Food was delicious too! Only downside was the transportation to get there took quite long, but it\'s worth it.',
                'status' => 'approved',
                'created_at' => now()->subWeek(),
                'updated_at' => now()->subWeek()
            ],
            [
                'user_id' => $mikeChen->id,
                'destination_id' => $danauToba->id_destinations,
                'rating' => 5,
                'comment' => 'Perfect place for photography enthusiasts! Every corner offers a new perspective. The sunrise and sunset views are spectacular. I spent 3 days here and it wasn\'t enough. Planning to come back next year!',
                'status' => 'approved',
                'created_at' => now()->subWeeks(2),
                'updated_at' => now()->subWeeks(2)
            ],

            // Tangkuban Perahu Reviews
            [
                'user_id' => $johnDoe->id,
                'destination_id' => $tangkubanPerahu->id_destinations,
                'rating' => 4,
                'comment' => 'Interesting volcanic crater with easy access by car. The crater view is impressive and the cool mountain air is refreshing. Good for day trips from Bandung. The souvenir shops have nice local products.',
                'status' => 'approved',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5)
            ],
            [
                'user_id' => $sarahWilson->id,
                'destination_id' => $tangkubanPerahu->id_destinations,
                'rating' => 4,
                'comment' => 'Nice place to visit with family. The kids enjoyed seeing the crater and learning about volcanoes. The weather was perfect and we had a great time. Parking is available but can get crowded on weekends.',
                'status' => 'approved',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8)
            ],

            // Borobudur Reviews
            [
                'user_id' => $sarahWilson->id,
                'destination_id' => $borobudur->id_destinations,
                'rating' => 5,
                'comment' => 'Absolutely magnificent! The sunrise tour was unforgettable. The ancient architecture and intricate carvings are mind-blowing. A true masterpiece of human civilization. The guide was very knowledgeable about the history.',
                'status' => 'approved',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3)
            ],
            [
                'user_id' => $mikeChen->id,
                'destination_id' => $borobudur->id_destinations,
                'rating' => 5,
                'comment' => 'World-class heritage site that exceeded my expectations. The preservation work is excellent and the stories behind each relief are fascinating. Don\'t miss the sunrise tour - it\'s magical!',
                'status' => 'approved',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],

            // Raja Ampat Reviews
            [
                'user_id' => $johnDoe->id,
                'destination_id' => $rajaAmpat->id_destinations,
                'rating' => 5,
                'comment' => 'Paradise for divers! The marine biodiversity is unreal - saw manta rays, sharks, and countless tropical fish. The coral reefs are pristine. Expensive to get there but absolutely worth every penny. Best diving experience of my life!',
                'status' => 'approved',
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15)
            ]
        ];

        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }

        // Update destination ratings after creating reviews
        $destinations = [
            $danauToba,
            $tangkubanPerahu,
            $borobudur,
            $rajaAmpat
        ];

        foreach ($destinations as $destination) {
            $destination->updateRatingStats();
        }

        $this->command->info('Sample destinations and reviews created successfully!');
        $this->command->info('Destinations created: ' . count($destinations));
        $this->command->info('Users created/updated: ' . count($users));
        $this->command->info('Reviews created: ' . count($reviews));
        $this->command->info('You can now test the review system!');
    }
}