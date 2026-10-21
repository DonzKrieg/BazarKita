import { test, expect } from '@playwright/test';

async function fill(page, register = false) {
    await page.locator('#account-email').fill('rani@example.test');
    await page.locator('#account-password').fill('Rekaan123!');
    if (register) await page.locator('#account-confirmation').fill('Rekaan123!');
}

test('register validates fields and duplicate email then continues to requested screen', async ({ page }, testInfo) => {
    const errors = [];
    const requests = [];
    page.on('pageerror', error => errors.push(error.message));
    page.on('request', request => requests.push(request));
    await page.goto('/login?next=profile');
    await page.getByRole('link', { name: 'Belum punya akun? Daftar' }).click();
    await expect(page).toHaveURL(/register\?next=profile$/);
    await page.locator('#account-email').fill('salah');
    await page.getByRole('button', { name: 'Daftar contoh', exact: true }).click();
    await expect(page.locator('#account-email')).toBeFocused();
    await expect(page.locator('#account-email')).toHaveAttribute('aria-invalid', 'true');
    await expect(page.getByText('Isi kata sandi contoh minimal 8 karakter.')).toBeVisible();
    await fill(page, true);
    await page.locator('#account-confirmation').fill('berbeda');
    await page.getByRole('button', { name: 'Daftar contoh', exact: true }).click();
    await expect(page.locator('#account-confirmation')).toBeFocused();
    await expect(page.getByText('Konfirmasi kata sandi belum sama.')).toBeVisible();
    await page.getByLabel('Skenario demonstrasi').selectOption('duplicate');
    await fill(page, true);
    await page.getByRole('button', { name: 'Daftar contoh', exact: true }).click();
    await expect(page.getByText('Email contoh sudah terdaftar. Silakan masuk.')).toBeVisible();
    await page.getByLabel('Skenario demonstrasi').selectOption('success');
    await fill(page, true);
    const count = requests.length;
    await page.getByRole('button', { name: 'Daftar contoh', exact: true }).click();
    await expect(page.getByRole('status')).toHaveText('Pendaftaran contoh berhasil. Tidak ada akun yang dibuat.');
    expect(requests.length).toBe(count);
    await expect(page.locator('#account-password')).toHaveValue('');
    await expect(page.locator('#account-confirmation')).toHaveValue('');
    expect(await page.evaluate(() => [localStorage.length, sessionStorage.length])).toEqual([0, 0]);
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
    await page.screenshot({ path: testInfo.outputPath('account-register.png'), fullPage: true });
    await page.getByRole('link', { name: 'Lanjut sebagai pengguna contoh' }).click();
    await expect(page).toHaveURL(/me\/profile\?as=user$/);
    expect(requests.every(r => !r.url().includes('Rekaan123') && !r.postData())).toBe(true);
    expect(errors).toEqual([]);
});

test('login demonstrates wrong password, limit, user, admin and logout', async ({ page }) => {
    await page.goto('/login?next=saved');
    await page.getByLabel('Skenario demonstrasi').selectOption('wrong');
    await fill(page);
    await page.getByRole('button', { name: 'Masuk contoh', exact: true }).click();
    await expect(page.locator('#account-password')).toBeFocused();
    await expect(page.getByText('Email atau kata sandi contoh salah. Periksa kembali isian Anda.')).toBeVisible();
    await expect(page.getByRole('link', { name: 'Lanjut sebagai pengguna contoh' })).toBeHidden();
    await page.getByLabel('Skenario demonstrasi').selectOption('limited');
    await fill(page);
    await page.getByRole('button', { name: 'Masuk contoh', exact: true }).click();
    await expect(page.getByRole('status')).toContainText('Percobaan masuk contoh dibatasi.');
    await expect(page.getByRole('status')).toBeFocused();
    await page.getByRole('button', { name: 'Atur ulang demonstrasi' }).click();
    await expect(page.locator('#account-email')).toHaveValue('');
    await fill(page);
    await page.getByRole('button', { name: 'Masuk contoh', exact: true }).click();
    await page.getByRole('link', { name: 'Lanjut sebagai pengguna contoh' }).click();
    await expect(page).toHaveURL(/saved-events\?as=user$/);
    await page.goto('/login');
    await page.getByLabel('Peran contoh').selectOption('admin');
    await fill(page);
    await page.getByRole('button', { name: 'Masuk contoh', exact: true }).click();
    await page.getByRole('link', { name: 'Lanjut sebagai admin contoh' }).click();
    await expect(page).toHaveURL(/contoh\/admin\?as=admin$/);
    await page.getByRole('button', { name: 'Keluar', exact: true }).click();
    await page.getByRole('dialog').getByRole('link', { name: 'Keluar dari contoh' }).click();
    await expect(page.getByRole('link', { name: 'Masuk', exact: true })).toBeVisible();
});

test('without JavaScript account fields remain disabled and public navigation works', async ({ browser }) => {
    const context = await browser.newContext({ javaScriptEnabled: false });
    const page = await context.newPage();
    await page.goto('http://127.0.0.1:8001/register');
    await expect(page.locator('#account-password')).toBeDisabled();
    await expect(page.getByRole('button', { name: 'Daftar contoh', exact: true })).toBeDisabled();
    await page.getByRole('link', { name: 'Lanjut sebagai pengunjung' }).click();
    await expect(page.getByRole('heading', { name: 'Bazar Mendatang', exact: true })).toBeVisible();
    await context.close();
});
