import { test, expect } from '@playwright/test';

async function openMenu(page) {
    if (page.viewportSize().width >= 1024) return;
    const toggle = page.locator('button[aria-controls="main-navigation"]');
    await expect(toggle).toBeVisible();
    await expect(toggle).toHaveAttribute('aria-expanded', /^(true|false)$/);
    if (await toggle.getAttribute('aria-expanded') === 'false') await toggle.click();
    await expect(page.getByRole('navigation', { name: 'Menu utama' })).toBeVisible();
}

test('four menus preserve example identity and login destination', async ({ page }, testInfo) => {
    await page.goto('/');
    await openMenu(page);
    const nav = page.getByRole('navigation', { name: 'Menu utama' });
    await expect(nav.getByRole('link')).toHaveText(['Beranda', 'Katalog Bazar', 'Tersimpan', 'Usaha Saya']);
    await expect(nav.getByRole('link', { name: 'Beranda', exact: true })).toHaveAttribute('aria-current', 'page');
    if (page.viewportSize().width >= 1024) {
        const brand = await page.getByRole('link', { name: 'BazarKita, beranda', exact: true }).boundingBox();
        const menu = await nav.boundingBox();
        const account = await page.getByRole('link', { name: 'Masuk', exact: true }).boundingBox();
        expect(Math.abs((brand.y + brand.height / 2) - (menu.y + menu.height / 2))).toBeLessThan(2);
        expect(menu.x).toBeGreaterThanOrEqual(brand.x + brand.width);
        expect(menu.x + menu.width).toBeLessThanOrEqual(account.x);
    }


    await openMenu(page);
    await nav.getByRole('link', { name: 'Tersimpan', exact: true }).click();
    await expect(page).toHaveURL(/\/login\?next=saved$/);
    await page.getByText('Navigasi contoh tanpa mengisi form', { exact: true }).click();
    await page.getByRole('link', { name: 'Coba sebagai pengguna', exact: true }).click();
    await expect(page).toHaveURL(/\/me\/saved-events\?as=user$/);
    await expect(page.getByText('Sudah berakhir', { exact: true })).toBeVisible();

    for (const name of ['Usaha Saya', 'Katalog Bazar', 'Beranda', 'Tersimpan']) {
        await openMenu(page);
        await nav.getByRole('link', { name, exact: true }).click();
        await openMenu(page);
        await expect(nav.getByRole('link', { name, exact: true })).toHaveAttribute('aria-current', 'page');
        await expect(page).toHaveURL(/as=user/);
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
    }
    if (page.viewportSize().width < 1024) await page.getByRole('button', { name: 'Tutup menu utama' }).click();
    await page.screenshot({ path: testInfo.outputPath('saved-navigation.png'), fullPage: true });
    await page.getByRole('button', { name: 'Keluar', exact: true }).click();
    const dialog = page.getByRole('dialog');
    await expect(dialog).toBeVisible();
    await expect(dialog.getByRole('button', { name: 'Batal' })).toBeFocused();
    await page.keyboard.press('Escape');
    await expect(dialog).toBeHidden();
    await expect(page.getByRole('button', { name: 'Keluar', exact: true })).toBeFocused();
    await page.getByRole('button', { name: 'Keluar', exact: true }).click();
    await dialog.getByRole('link', { name: 'Keluar dari contoh' }).click();
    await expect(page.getByRole('link', { name: 'Masuk', exact: true })).toBeVisible();
    await openMenu(page);
    await nav.getByRole('link', { name: 'Usaha Saya', exact: true }).click();
    await expect(page).toHaveURL(/\/login\?next=profile$/);
    await page.getByText('Navigasi contoh tanpa mengisi form', { exact: true }).click();
    await page.getByRole('link', { name: 'Coba sebagai pengguna', exact: true }).click();
    await expect(page.getByRole('heading', { name: 'Usaha Saya', exact: true })).toBeVisible();
});

test('shared form and native dialog are usable with keyboard', async ({ page }, testInfo) => {
    const errors = [];
    page.on('pageerror', error => errors.push(error.message));
    await page.goto('/contoh/komponen');
    await page.getByRole('button', { name: 'Periksa contoh isian' }).click();
    const input = page.getByLabel('Nama usaha', { exact: false });
    await expect(input).toBeFocused();
    await expect(input).toHaveAttribute('aria-invalid', 'true');
    await expect(page.getByText('Isi nama usaha terlebih dahulu.')).toBeVisible();
    await input.fill('Dapur Contoh');
    await page.getByLabel('Jenis produk', { exact: true }).selectOption('drink');
    await page.getByRole('button', { name: 'Periksa contoh isian' }).click();
    await expect(input).toHaveAttribute('aria-invalid', 'false');
    await expect(page.getByText('Contoh isian sudah lengkap. Tidak ada data yang disimpan.')).toBeVisible();

    const trigger = page.getByRole('button', { name: 'Coba dialog konfirmasi' });
    await trigger.focus();
    await page.keyboard.press('Enter');
    const dialog = page.getByRole('dialog');
    await expect(dialog).toBeVisible();
    await page.keyboard.press('Shift+Tab');
    await expect(dialog.getByRole('button', { name: 'Lanjutkan contoh', exact: true })).toBeFocused();
    for (let i = 0; i < 5; i++) {
        await page.keyboard.press('Tab');
        expect(await dialog.evaluate(el => el.contains(document.activeElement))).toBe(true);
    }
    await dialog.getByRole('button', { name: 'Batal' }).click();
    await expect(trigger).toBeFocused();
    await trigger.click();
    await dialog.getByRole('button', { name: 'Lanjutkan contoh', exact: true }).click();
    await expect(dialog).toBeHidden();
    await expect(page.getByText('Contoh konfirmasi selesai. Tidak ada data yang disimpan.')).toBeVisible();
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
    await page.screenshot({ path: testInfo.outputPath('shared-components.png'), fullPage: true });
    expect(errors).toEqual([]);
});
