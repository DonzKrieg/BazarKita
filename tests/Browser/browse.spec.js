import { test, expect } from '@playwright/test';
const cards = page => page.locator('article:visible');

test('catalog filters all active examples and separates unknown data from mismatches', async ({ page }, info) => {
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    await page.goto('/events');
    await expect(cards(page)).toHaveCount(6);
    await expect(page.getByText('Ruang Rasa Lengkong')).toHaveCount(0);
    await page.getByLabel('Batas sewa per hari (Rp)', { exact: true }).fill('0');
    await expect(page.getByRole('region', { name: 'Perlu ditanyakan' })).toBeVisible();
    await expect(cards(page)).toHaveCount(2); // confirmed free + unknown price
    await expect(cards(page).filter({ hasText: 'Pasar Warga Antapani' })).toHaveCount(0);
    await page.getByLabel('Jenis produk', { exact: true }).selectOption('Minuman');
    await expect(cards(page)).toHaveCount(1); // a definite category mismatch beats unknown price
    await page.getByRole('button', { name: 'Hapus filter' }).click();
    await page.getByLabel('Nama atau tempat').fill('coblong');
    await page.getByLabel('Batas sewa per hari (Rp)', { exact: true }).fill('33333');
    await expect(cards(page)).toHaveCount(0);
    await page.getByLabel('Batas sewa per hari (Rp)', { exact: true }).fill('33334');
    await expect(cards(page)).toHaveCount(1);
    await expect(cards(page)).toContainText('Setara Rp33.334/hari');
    await page.getByLabel('Nama atau tempat').fill('cikutra');
    await page.getByLabel('Batas sewa per hari (Rp)', { exact: true }).fill('139999');
    await expect(cards(page)).toHaveCount(0);
    await page.getByLabel('Batas sewa per hari (Rp)', { exact: true }).fill('140000');
    await expect(cards(page)).toHaveCount(1);
    await page.getByRole('button', { name: 'Hapus filter' }).click();
    await page.getByLabel('Lokasi asal', { exact: true }).fill('Daerah tak dikenal');
    await page.getByLabel('Jarak maksimal (km)', { exact: true }).fill('10');
    await expect(page.getByRole('region', { name: 'Perlu ditanyakan' }).locator('article:visible')).toHaveCount(6);
    await page.getByLabel('Lokasi asal', { exact: true }).fill('Coblong, Bandung');
    await expect(page.getByRole('region', { name: 'Perlu ditanyakan' })).toBeHidden();
    await page.getByLabel('Mulai tersedia (WIB)').fill('2026-11-10');
    await page.getByLabel('Selesai tersedia (WIB)').fill('2026-11-09');
    await expect(page.getByRole('alert')).toContainText('Tanggal selesai tidak boleh');
    await page.getByRole('button', { name: 'Hapus filter' }).click();
    await page.getByLabel('Fasilitas', { exact: true }).selectOption('Air');
    await expect(cards(page)).toHaveCount(1);
    await expect(page.getByRole('region', { name: 'Perlu ditanyakan' })).toContainText('Temu Usaha Cicendo');
    await page.screenshot({ path: info.outputPath('catalog.png'), fullPage: true });
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
    expect(errors).toEqual([]);
});

test('home caps eligible distinct choices and falls back for incomplete profiles', async ({ page }) => {
    await page.goto('/?as=user');
    await expect(page.getByRole('heading', { name: 'Pilihan untuk Usaha Anda' })).toBeVisible();
    for (const [scenario, count] of [['0', 0], ['1', 1], ['2', 2], ['3', 3], ['5', 3]]) {
        await page.getByLabel('Coba jumlah pilihan').selectOption(scenario);
        await expect(cards(page)).toHaveCount(count);
        for (const reasons of await page.locator('ul[aria-label="Alasan pilihan"]:visible').all()) await expect(reasons.locator('li')).toHaveCount(2);
    }
    await page.getByLabel('Coba jumlah pilihan').selectOption('incomplete');
    await expect(page.getByRole('heading', { name: 'Bazar Mendatang', exact: true })).toBeVisible();
    await expect(cards(page)).toHaveCount(3);
    await expect(page.locator('ul[aria-label="Alasan pilihan"]:visible')).toHaveCount(0);
    await page.getByRole('link', { name: 'Lihat Semua Bazar', exact: true }).click();
    await expect(cards(page)).toHaveCount(6);
    await page.goto('/me/profile?as=user');
    await page.locator('#profile-rent').fill('0');
    await page.getByRole('button', { name: 'Terapkan perubahan contoh' }).click();
    await page.getByRole('link', { name: 'Lihat Beranda' }).click();
    await expect(cards(page)).toHaveCount(1);
    await expect(cards(page)).toContainText('Temu Kreatif Sukajadi');
});

test('detail exposes rental obligations, source, contact and local correction without mutation', async ({ page }, info) => {
    await page.goto('/events/bazar-braga');
    await expect(page.getByText('Wajib sewa 3 hari', { exact: true })).toBeVisible();
    await expect(page.getByText('Harga paket Rp450.000', { exact: true })).toBeVisible();
    await expect(page.getByText('Biaya tambahan wajib: belum ada informasi.')).toBeVisible();
    await page.getByRole('button', { name: 'Informasi Lainnya', exact: true }).click();
    await expect(page.getByText('Catatan penyelenggara — Contoh.', { exact: false })).toBeVisible();
    await page.getByRole('button', { name: 'Kirim laporan contoh' }).click();
    await expect(page.getByLabel('Alasan laporan')).toBeFocused();
    const requests = [];
    page.on('request', r => requests.push(r));
    await page.getByLabel('Alasan laporan').fill('Tanggal pada poster berbeda — contoh');
    await page.getByRole('button', { name: 'Kirim laporan contoh' }).click();
    await expect(page.getByRole('status')).toContainText('Tidak ada laporan dikirim');
    expect(requests).toEqual([]);
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
    await page.screenshot({ path: info.outputPath('detail.png'), fullPage: true });
    await page.goto('/events/bazar-cikutra');
    await expect(page.getByText('Silakan pastikan kembali kepada penyelenggara.')).toBeVisible();
    await page.goto('/events/bazar-cicendo');
    await expect(page.getByText('Tanyakan harga sewa', { exact: true })).toBeVisible();
    await expect(page.getByRole('button', { name: 'Hubungi Penyelenggara' })).toHaveCount(0);
    await page.goto('/events/bazar-dago?as=user');
    await expect(page.getByRole('navigation', { name: 'Menu utama' }).getByRole('link', { name: 'Katalog Bazar' })).toHaveAttribute('aria-current', 'page');
    await page.getByRole('button', { name: 'Alasan pilihan', exact: true }).click();
    await expect(page.getByText('Jenis produk Makanan diterima.', { exact: true })).toBeVisible();
    await page.getByRole('button', { name: 'Hubungi Penyelenggara' }).click();
    await expect(page.getByRole('dialog')).toContainText('alamat rekaan');
});
