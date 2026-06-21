<?php

namespace Database\Seeders;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Ikan Kering', 'slug' => 'ikan-kering', 'description' => 'Ikan kering segar dari perairan Pulau Pangkor', 'icon' => '🐟'],
            ['name' => 'Udang Kering', 'slug' => 'udang-kering', 'description' => 'Udang kering berkualiti tinggi', 'icon' => '🦐'],
            ['name' => 'Sotong Kering', 'slug' => 'sotong-kering', 'description' => 'Sotong kering yang sedap dan kenyal', 'icon' => '🦑'],
            ['name' => 'Ikan Masin', 'slug' => 'ikan-masin', 'description' => 'Ikan masin pelbagai jenis', 'icon' => '🧂'],
            ['name' => 'Belacan & Sambal', 'slug' => 'belacan-sambal', 'description' => 'Belacan dan sambal homemade', 'icon' => '🌶️'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $products = [
            // Ikan Kering
            ['category' => 'ikan-kering', 'name' => 'Ikan Bilis Mata Biru', 'price' => 18.00, 'compare' => 22.00, 'unit' => '500g', 'weight' => 500, 'stock' => 50, 'featured' => true,
                'desc' => 'Ikan bilis mata biru premium dari perairan Pangkor. Bersih, putih, dan rangup — sesuai untuk sambal, nasi lemak, atau dimakan terus sebagai kudapan.'],
            ['category' => 'ikan-kering', 'name' => 'Ikan Bilis Biasa', 'price' => 12.00, 'compare' => null, 'unit' => '500g', 'weight' => 500, 'stock' => 80, 'featured' => false,
                'desc' => 'Ikan bilis biasa gred A. Sesuai untuk masakan harian.'],
            ['category' => 'ikan-kering', 'name' => 'Ikan Kembung Kering', 'price' => 15.00, 'compare' => 18.00, 'unit' => '3 ekor', 'weight' => 300, 'stock' => 30, 'featured' => false,
                'desc' => 'Ikan kembung kering yang dijemur secara tradisional. Sedap digoreng atau dimasak sambal.'],
            ['category' => 'ikan-kering', 'name' => 'Ikan Gelama Kering', 'price' => 22.00, 'compare' => null, 'unit' => '500g', 'weight' => 500, 'stock' => 25, 'featured' => true,
                'desc' => 'Ikan gelama kering premium — isi tebal, kurang tulang. Paling sedap dibuat gulai atau goreng kunyit.'],

            // Ikan Masin
            ['category' => 'ikan-masin', 'name' => 'Ikan Masin Talang', 'price' => 20.00, 'compare' => 25.00, 'unit' => '500g', 'weight' => 500, 'stock' => 35, 'featured' => true,
                'desc' => 'Ikan talang masin isi tebal. Diproses dengan garam laut asli. Sedap digoreng rangup makan dengan nasi panas.'],
            ['category' => 'ikan-masin', 'name' => 'Ikan Masin Kurau', 'price' => 28.00, 'compare' => null, 'unit' => '500g', 'weight' => 500, 'stock' => 20, 'featured' => false,
                'desc' => 'Ikan kurau masin — premium grade. Isi lembut, kurang tulang.'],
            ['category' => 'ikan-masin', 'name' => 'Ikan Masin Selar', 'price' => 10.00, 'compare' => null, 'unit' => '500g', 'weight' => 500, 'stock' => 60, 'featured' => false,
                'desc' => 'Ikan selar masin — pilihan ekonomi untuk masakan harian.'],

            // Udang Kering
            ['category' => 'udang-kering', 'name' => 'Udang Kering Gred A', 'price' => 35.00, 'compare' => 42.00, 'unit' => '250g', 'weight' => 250, 'stock' => 40, 'featured' => true,
                'desc' => 'Udang kering gred A — saiz besar, warna oren cerah, aroma kuat. Sempurna untuk sambal, nasi goreng, dan kerabu.'],
            ['category' => 'udang-kering', 'name' => 'Udang Kering Kisar', 'price' => 18.00, 'compare' => null, 'unit' => '250g', 'weight' => 250, 'stock' => 55, 'featured' => false,
                'desc' => 'Serbuk udang kering halus — sedia guna untuk perencah masakan.'],
            ['category' => 'udang-kering', 'name' => 'Udang Geragau', 'price' => 15.00, 'compare' => null, 'unit' => '250g', 'weight' => 250, 'stock' => 45, 'featured' => false,
                'desc' => 'Udang geragau halus — untuk cencaluk, sambal, dan kerabu.'],

            // Sotong Kering
            ['category' => 'sotong-kering', 'name' => 'Sotong Kering Besar', 'price' => 30.00, 'compare' => 38.00, 'unit' => '250g', 'weight' => 250, 'stock' => 25, 'featured' => true,
                'desc' => 'Sotong kering saiz besar — manis semulajadi, kenyal. Sesuai untuk sambal sotong, goreng tepung, atau dimakan dengan sos cili.'],
            ['category' => 'sotong-kering', 'name' => 'Sotong Kering Potong', 'price' => 25.00, 'compare' => null, 'unit' => '250g', 'weight' => 250, 'stock' => 30, 'featured' => false,
                'desc' => 'Sotong kering yang dipotong siap — mudah untuk dimasak terus.'],
            ['category' => 'sotong-kering', 'name' => 'Sotong Kering Cincin', 'price' => 28.00, 'compare' => null, 'unit' => '200g', 'weight' => 200, 'stock' => 20, 'featured' => true,
                'desc' => 'Sotong kering bentuk cincin — popular untuk goreng tepung rangup.'],

            // Belacan & Sambal
            ['category' => 'belacan-sambal', 'name' => 'Belacan Homemade Pangkor', 'price' => 12.00, 'compare' => null, 'unit' => '200g', 'weight' => 200, 'stock' => 100, 'featured' => true,
                'desc' => 'Belacan buatan sendiri menggunakan udang geragau segar. Dijemur secara tradisional — aroma dan rasa yang tiada tandingan.'],
            ['category' => 'belacan-sambal', 'name' => 'Sambal Hitam Pahang', 'price' => 16.00, 'compare' => 20.00, 'unit' => '350g', 'weight' => 350, 'stock' => 45, 'featured' => true,
                'desc' => 'Sambal hitam Pahang versi Pangkor — dimasak perlahan dengan rempah pilihan. Sedap dengan nasi lemak, roti canai, atau sebagai pencicah.'],
            ['category' => 'belacan-sambal', 'name' => 'Sambal Ikan Bilis', 'price' => 14.00, 'compare' => null, 'unit' => '300g', 'weight' => 300, 'stock' => 50, 'featured' => false,
                'desc' => 'Sambal ikan bilis homemade — pedas, manis, dan penuh dengan ikan bilis.'],
            ['category' => 'belacan-sambal', 'name' => 'Sambal Tumis Udang Kering', 'price' => 17.00, 'compare' => null, 'unit' => '300g', 'weight' => 300, 'stock' => 35, 'featured' => false,
                'desc' => 'Sambal tumis dengan udang kering segar. Dimasak dengan bawang dan cili kering pilihan.'],
        ];

        foreach ($products as $i => $p) {
            $cat = Category::where('slug', $p['category'])->first();
            Product::create([
                'shop_category_id' => $cat->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => $p['desc'],
                'price' => $p['price'],
                'compare_price' => $p['compare'],
                'unit' => $p['unit'],
                'weight_grams' => $p['weight'],
                'stock' => $p['stock'],
                'is_active' => true,
                'is_featured' => $p['featured'],
                'sort_order' => $i,
            ]);
        }
    }
}
