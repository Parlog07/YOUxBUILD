<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'CPUs', 'description' => 'Desktop and workstation processors from Intel and AMD.'],
            ['name' => 'Motherboards', 'description' => 'ATX, Micro-ATX, and Mini-ITX motherboards for PC builds.'],
            ['name' => 'GPUs', 'description' => 'Dedicated graphics cards for gaming, rendering, and AI workloads.'],
            ['name' => 'RAM', 'description' => 'DDR4 and DDR5 memory kits for desktop computers.'],
            ['name' => 'SSDs', 'description' => 'SATA and NVMe solid state drives for fast storage.'],
            ['name' => 'HDDs', 'description' => 'Mechanical hard drives for bulk storage and backups.'],
            ['name' => 'Power Supplies', 'description' => 'PSUs with different wattages and efficiency ratings.'],
            ['name' => 'PC Cases', 'description' => 'Computer cases for gaming, workstation, and compact builds.'],
            ['name' => 'CPU Coolers', 'description' => 'Air coolers and AIO liquid coolers for processors.'],
            ['name' => 'Case Fans', 'description' => 'Cooling fans for airflow, RGB setups, and thermal management.'],
            ['name' => 'Thermal Paste', 'description' => 'Thermal compounds and pads for CPU and GPU cooling.'],
            ['name' => 'Monitors', 'description' => 'Gaming, office, and professional display monitors.'],
            ['name' => 'Keyboards', 'description' => 'Mechanical, membrane, and wireless keyboards.'],
            ['name' => 'Mice', 'description' => 'Gaming and productivity mice with different sensor types.'],
            ['name' => 'Headsets', 'description' => 'Wired and wireless headsets for gaming and communication.'],
            ['name' => 'Speakers', 'description' => 'Desktop speaker systems and audio accessories.'],
            ['name' => 'Webcams', 'description' => 'USB webcams for streaming, meetings, and content creation.'],
            ['name' => 'Capture Cards', 'description' => 'Video capture devices for streaming and recording.'],
            ['name' => 'Networking', 'description' => 'Wi-Fi adapters, routers, switches, and networking accessories.'],
            ['name' => 'Accessories', 'description' => 'Cables, adapters, brackets, and general PC accessories.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
