<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FrontendFoundationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::shouldReceive('connection')->never();
        Http::preventStrayRequests();
    }

    public function test_home_renders_blade_examples_with_visible_rental_terms(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertViewIs('pages.home')
            ->assertSee('lang="id"', false)
            ->assertSee('Contoh')
            ->assertSee('Bazar Mendatang')
            ->assertSee('Rp125.000/hari')
            ->assertSee('Setara Rp150.000/hari')
            ->assertSee('Wajib sewa 3 hari')
            ->assertSee('Harga paket Rp450.000')
            ->assertSee('Biaya wajib: kebersihan Rp10.000/hari.')
            ->assertSee('Tanyakan harga sewa')
            ->assertDontSee('Ruang Rasa Lengkong')
            ->assertViewHas('screen', fn (array $screen) => count($screen['events']) === 3
                && $screen['viewer']['role'] === 'guest'
                && $screen['meta']['is_example'] === true);
        Http::assertNothingSent();
    }

    #[DataProvider('screenStates')]
    public function test_screen_states_render_without_external_services(string $state, string $message): void
    {
        $this->get('/?state='.$state)
            ->assertOk()
            ->assertSee($message)
            ->assertViewHas('screen', fn (array $screen) => $screen['state'] === $state && $screen['events'] === []);
        Http::assertNothingSent();
    }

    public static function screenStates(): array
    {
        return [
            'loading' => ['loading', 'Sedang memuat bazar'],
            'empty' => ['empty', 'Belum ada bazar yang sesuai'],
            'error' => ['error', 'Informasi belum berhasil dimuat'],
            'success' => ['success', 'Contoh berhasil ditampilkan'],
        ];
    }

    public function test_admin_is_explicitly_a_public_non_mutating_example(): void
    {
        $this->get('/contoh/admin')
            ->assertOk()
            ->assertSee('Contoh halaman admin')
            ->assertSee('Dina Contoh')
            ->assertSee('Tidak ada proses masuk, perubahan data, atau penerbitan acara.')
            ->assertSee('Perlu diperiksa')
            ->assertSee('Dibatalkan')
            ->assertSee('Sudah berakhir')
            ->assertSee('Ditarik dari katalog')
            ->assertSee('Setara Rp33.334/hari');
        Http::assertNothingSent();
    }

    public function test_invalid_state_does_not_become_a_view_or_file_path(): void
    {
        $this->get('/?state=../../.env')->assertNotFound();
        $this->get('/?state[]=ready')->assertNotFound();
    }

    public function test_blade_escapes_fixture_content(): void
    {
        $fixtures = require resource_path('fixtures/frontend.php');
        $event = $fixtures['events'][0];
        $event['name'] = '<script>alert("example")</script>';

        $this->blade('<x-event-preview :event="$event" />', ['event' => $event])
            ->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<script>alert', false);
    }

    public function test_fixtures_preserve_unknown_prices_and_package_source_amounts(): void
    {
        $fixtures = require resource_path('fixtures/frontend.php');
        $events = collect($fixtures['events'])->keyBy('id');

        $this->assertTrue($fixtures['meta']['is_example']);
        $this->assertSame(['guest', 'user', 'admin'], array_keys($fixtures['viewers']));
        $this->assertSame(450000, $events['bazar-braga']['offer']['source_amount']);
        $this->assertSame(3, $events['bazar-braga']['offer']['rental_days']);
        $this->assertNull($events['bazar-cicendo']['offer']['rental_days']);
        $this->assertNull($events['bazar-cicendo']['offer']['daily_amount']);
        $this->assertNull($events['bazar-cicendo']['offer']['mandatory_fees']);
        $this->assertSame(0, $events['bazar-antapani']['offer']['daily_amount']);
        $this->assertSame([], $events['bazar-antapani']['offer']['mandatory_fees']);
    }
}
