<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BrowseFrontendTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::shouldReceive('connection')->never();
        Http::preventStrayRequests();
    }

    public function test_catalog_contains_all_published_examples_and_excludes_inactive_events(): void
    {
        $this->get('/events')->assertOk()
            ->assertSee('Pasar Komunitas Coblong')
            ->assertSee('Perlu ditanyakan')
            ->assertDontSee('Ruang Rasa Lengkong')
            ->assertDontSee('Pasar Warga Antapani')
            ->assertDontSee('Temu Kuliner Buahbatu')
            ->assertDontSee('Pasar Sore Cibiru')
            ->assertViewHas('screen', fn ($screen) => count($screen['events']) === 6);
    }

    public function test_detail_is_read_only_and_preserves_package_obligations(): void
    {
        $this->get('/events/bazar-braga?as=user')->assertOk()
            ->assertSee('Wajib sewa 3 hari')
            ->assertSee('Harga paket Rp450.000')
            ->assertSee('Biaya tambahan wajib: belum ada informasi.')
            ->assertSee('Informasi Lainnya')
            ->assertSee('Laporkan Informasi');
        $this->get('/events/bazar-cikutra')->assertOk()->assertSee('Silakan pastikan kembali kepada penyelenggara.');
        $this->get('/events/bazar-dago')->assertOk()->assertSee('Hubungi Penyelenggara');
        foreach (['missing', 'bazar-lengkong', 'bazar-antapani', 'bazar-buahbatu', 'bazar-cibiru'] as $id) {
            $this->get('/events/'.$id)->assertNotFound();
        }
        Http::assertNothingSent();
    }
}
