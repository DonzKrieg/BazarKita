import { test, expect } from '@playwright/test';

test('P18: layout, keyboard and Alpine work with local assets', async ({ page }, testInfo) => {
    const errors = [];
    const externalRequests = [];
    page.on('pageerror', error => errors.push(error.message));
    page.on('request', request => {
        if (new URL(request.url()).hostname !== '127.0.0.1') externalRequests.push(request.url());
    });

    await page.goto('/');
    await expect(page.locator('html')).toHaveAttribute('lang', 'id');
    await expect(page.locator('body')).toHaveCSS('background-color', 'rgb(250, 249, 246)');
    await expect(page.locator('article:visible')).toHaveCount(3);

    await page.keyboard.press('Tab');
    await expect(page.getByRole('link', { name: 'Lewati ke konten' })).toBeFocused();
    await page.keyboard.press('Enter');
    await expect(page.locator('#konten')).toBeFocused();

    const card = page.locator('article').filter({ hasText: 'Pekan Kuliner Braga' });
    await expect(card.getByText('Wajib sewa 3 hari')).toBeVisible();
    await expect(card.getByText('Harga paket Rp450.000')).toBeVisible();
    await expect(card.getByText('Biaya tambahan wajib: belum ada informasi.')).toBeVisible();
    const toggle = card.getByRole('button');
    await toggle.focus();
    await page.keyboard.press('Enter');
    await expect(toggle).toHaveAttribute('aria-expanded', 'true');
    await expect(page.locator('#sumber-bazar-braga')).toBeVisible();
    await page.keyboard.press('Enter');
    await expect(toggle).toHaveAttribute('aria-expanded', 'false');
    await expect(page.locator('#sumber-bazar-braga')).toBeHidden();

    expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth)).toBe(true);
    await page.screenshot({ path: testInfo.outputPath('home.png'), fullPage: true });

    await page.getByRole('link', { name: 'Lihat contoh halaman admin' }).click();
    await expect(page.getByRole('heading', { name: 'Kelola Bazar' })).toBeVisible();
    await expect(page.locator('article')).toHaveCount(7);
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth)).toBe(true);
    await page.screenshot({ path: testInfo.outputPath('admin.png'), fullPage: true });
    expect(errors).toEqual([]);
    expect(externalRequests).toEqual([]);
});

test('P20: screen states and retry links are usable', async ({ page }) => {
    for (const [state, title] of Object.entries({
        loading: 'Sedang memuat bazar',
        empty: 'Belum ada bazar yang sesuai',
        error: 'Informasi belum berhasil dimuat',
        success: 'Contoh berhasil ditampilkan',
    })) {
        await page.goto('/?state=' + state);
        await expect(page.locator('#bazar').getByText(title, { exact: true })).toBeVisible();
        await expect(page.locator('article')).toHaveCount(0);
        await page.getByRole('link', { name: state === 'error' ? 'Coba lagi' : 'Kembali ke contoh bazar', exact: true }).click();
        await expect(page.locator('article:visible')).toHaveCount(3);
    }
});
