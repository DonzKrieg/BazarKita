import { test, expect } from '@playwright/test';

const input = (page, name) => page.locator(`#profile-${name}`);
const save = page => page.getByRole('button', { name: 'Terapkan perubahan contoh' }).click();

test('profile validation distinguishes missing, zero, invalid coordinates and reversed ranges', async ({ page }) => {
    await page.goto('/me/profile?as=user');
    await page.getByRole('button', { name: 'Coba profil belum lengkap' }).click();
    await save(page);
    await expect(input(page, 'category')).toBeFocused();
    await expect(input(page, 'rent')).toHaveAttribute('aria-invalid', 'true');
    await page.getByRole('button', { name: 'Kembalikan contoh awal' }).click();
    for (const [field, value] of [['radius', '0'], ['rent', '-1'], ['latitude', '91'], ['longitude', '-181'], ['end', '2026-11-06']]) {
        await input(page, field).fill(value);
    }
    await save(page);
    for (const field of ['radius', 'rent', 'latitude', 'longitude', 'end']) await expect(input(page, field)).toHaveAttribute('aria-invalid', 'true');
    await expect(input(page, 'latitude')).toBeFocused();
    await input(page, 'radius').fill('-2');
    await save(page);
    await expect(input(page, 'radius')).toHaveAttribute('aria-invalid', 'true');
    await page.getByRole('button', { name: 'Kembalikan contoh awal' }).click();
    await page.getByRole('button', { name: 'Tambahkan Informasi Usaha' }).click();
    await input(page, 'min').fill('50000');
    await input(page, 'max').fill('10000');
    await page.getByRole('button', { name: 'Tambahkan Informasi Usaha' }).click();
    await save(page);
    await expect(input(page, 'max')).toBeVisible();
    await expect(input(page, 'max')).toBeFocused();
    await expect(page.getByText('Harga tertinggi tidak boleh di bawah harga terendah.')).toBeVisible();
    await input(page, 'min').fill('');
    await save(page);
    await expect(input(page, 'min')).toBeFocused();
    await input(page, 'max').fill('');
    await input(page, 'rent').fill('0');
    await input(page, 'latitude').fill('0');
    await input(page, 'longitude').fill('0');
    await save(page);
    await expect(page.getByRole('status')).toContainText('Perubahan contoh diterapkan');
});

test('profile edits reach home and reload without network submission, reset restores fixture', async ({ page }, testInfo) => {
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    await page.goto('/me/profile?as=user');
    await input(page, 'category').selectOption('Minuman');
    await input(page, 'rent').fill('0');
    await input(page, 'location').fill('Lokasi Contoh');
    await page.getByRole('button', { name: 'Tambahkan Informasi Usaha' }).click();
    await input(page, 'name').fill('Kedai Contoh');
    await page.getByLabel('Air', { exact: true }).check();
    const requests = [];
    page.on('request', request => requests.push(request.url()));
    await save(page);
    await expect(page.getByRole('status')).toBeFocused();
    expect(requests).toEqual([]);
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
    await page.screenshot({ path: testInfo.outputPath('profile.png'), fullPage: true });
    await page.getByRole('link', { name: 'Lihat Beranda' }).click();
    await expect(page.getByRole('complementary', { name: 'Profil contoh' })).toContainText('Minuman · Lokasi Contoh · 10 km · Rp0/hari');
    await page.getByRole('link', { name: 'Ubah Usaha Saya' }).click();
    await page.reload();
    await expect(input(page, 'rent')).toHaveValue('0');
    await page.getByRole('button', { name: 'Tambahkan Informasi Usaha' }).click();
    await expect(input(page, 'name')).toHaveValue('Kedai Contoh');
    await expect(page.getByLabel('Air', { exact: true })).toBeChecked();
    await page.getByRole('button', { name: 'Kembalikan contoh awal' }).click();
    await expect(input(page, 'rent')).toHaveValue('150000');
    expect(await page.evaluate(() => sessionStorage.getItem('bazarkita.profile-preview.v1.user'))).toBeNull();
    expect(errors).toEqual([]);
});

test('blocked browser storage gives a useful message without losing edits', async ({ page }) => {
    await page.addInitScript(() => {
        Storage.prototype.setItem = () => { throw new Error('Storage blocked'); };
    });
    await page.goto('/me/profile?as=user');
    await input(page, 'rent').fill('200000');
    await save(page);
    await expect(page.getByRole('status')).toContainText('Penyimpanan sementara browser tidak tersedia');
    await expect(input(page, 'rent')).toHaveValue('200000');
});
