<?php

namespace Database\Factories;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaksi::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $waktuPinjam = Carbon::now()->subDays(rand(1, 30))->subHours(rand(1, 24));
        $status = $this->faker->randomElement(['aktif', 'kembali']);
        $waktuKembali = $status === 'kembali' ? 
            (clone $waktuPinjam)->addHours(rand(1, 72)) : 
            null;

        return [
            'kode_barang' => 'BRG-' . $this->faker->unique()->numberBetween(1000, 9999),
            'nama_peminjam' => $this->faker->name(),
            'waktu_pinjam' => $waktuPinjam,
            'waktu_kembali' => $waktuKembali,
            'status' => $status,
        ];
    }
}