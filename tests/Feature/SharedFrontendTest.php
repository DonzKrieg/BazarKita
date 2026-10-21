<?php

namespace Tests\Feature;

use App\Support\Display;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SharedFrontendTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::shouldReceive('connection')->never();
        Http::preventStrayRequests();
    }

    #[DataProvider('pages')]
    public function test_pages_use_four_main_links_and_no_services(string $url, string $title): void
    {
        $response = $this->get($url)->assertOk()->assertSee($title);
        $dom = new \DOMDocument;
        @$dom->loadHTML($response->getContent());
        $xpath = new \DOMXPath($dom);
        $links = $xpath->query('//nav[@aria-label="Menu utama"]//a');
        $this->assertSame(
            ['Beranda', 'Katalog Bazar', 'Tersimpan', 'Usaha Saya'],
            array_map(fn ($link) => trim($link->textContent), iterator_to_array($links)),
        );
        Http::assertNothingSent();
    }

    public static function pages(): array
    {
        return [
            ['/', 'Bazar Mendatang'],
            ['/events', 'Katalog Bazar'],
            ['/me/saved-events?as=user', 'Tersimpan'],
            ['/me/profile?as=user', 'Usaha Saya'],
            ['/login', 'Coba sebagai pengguna'],
            ['/contoh/admin', 'Kelola Bazar'],
            ['/contoh/komponen', 'Panduan tampilan'],
        ];
    }

    public function test_private_menu_preserves_destination_through_example_login(): void
    {
        $this->get('/me/saved-events')->assertRedirect(route('login', ['next' => 'saved']));
        $this->get('/me/profile')->assertRedirect(route('login', ['next' => 'profile']));
        $this->get('/login?next=saved')->assertSee(route('saved', ['as' => 'user']));
        $this->get('/login?next=profile')->assertSee(route('profile', ['as' => 'user']));
        $this->get('/login?next=https://example.com')->assertNotFound();
        $this->get('/login?next[]=home')->assertNotFound();
        $this->get('/?as[]=admin')->assertNotFound();
        $this->get('/?as=owner')->assertNotFound();
    }

    public function test_saved_examples_keep_finished_status_visible(): void
    {
        $this->get('/me/saved-events?as=user')->assertOk()
            ->assertSee('Sudah berakhir')->assertSee('Temu Kuliner Buahbatu')
            ->assertDontSee('Ruang Rasa Lengkong');
    }

    public function test_form_labels_hints_errors_and_escaping_are_connected(): void
    {
        $this->blade('<x-form-field id="rent" label="Batas sewa" hint="Per hari" error="Isi dengan benar" value="<script>bad</script>" />')
            ->assertSee('for="rent"', false)
            ->assertSee('aria-describedby="rent-hint rent-error"', false)
            ->assertSee('aria-invalid="true"', false)
            ->assertSee('&lt;script&gt;bad&lt;/script&gt;', false);
    }

    public function test_presentation_formatting_keeps_zero_unknown_and_wib_date_boundaries(): void
    {
        $this->assertSame('Rp150.000', Display::rupiah(150000));
        $this->assertSame('Rp0', Display::rupiah(0));
        $this->assertSame('Belum ada informasi', Display::rupiah(null));
        $this->assertSame('2 November 2026, 01.30 WIB', Display::wib('2026-11-01T18:30:00Z'));
        $this->assertSame('1 November 2026, 09.00 WIB', Display::wib('2026-11-01T02:00:00Z'));
        $this->assertSame('Belum ada informasi', Display::wib(null));
    }
}
