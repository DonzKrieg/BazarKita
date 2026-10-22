import { test, expect } from '@playwright/test';

test('navigation collapses accessibly on small screens and remains inline on desktop', async ({ page }, info) => {
    await page.goto('/?as=user');
    const nav = page.getByRole('navigation', { name: 'Menu utama' });
    if (page.viewportSize().width < 1024) {
        const toggle = page.getByRole('button', { name: 'Buka menu utama' });
        await expect(nav).toBeHidden();
        await toggle.focus();
        await page.keyboard.press('Enter');
        await expect(nav).toBeVisible();
        await expect(page.getByRole('button', { name: 'Tutup menu utama' })).toHaveAttribute('aria-expanded', 'true');
        await nav.getByRole('link', { name: 'Katalog Bazar' }).focus();
        await page.keyboard.press('Escape');
        await expect(nav).toBeHidden();
        await expect(toggle).toBeFocused();
        await toggle.click();
        await page.screenshot({ path: info.outputPath('mobile-menu.png'), fullPage: true });
        await nav.getByRole('link', { name: 'Katalog Bazar' }).click();
        await expect(page).toHaveURL(/events\?as=user$/);
        await expect(nav).toBeHidden();
        await page.setViewportSize({ width: 1280, height: 900 });
        await expect(nav).toBeVisible();
    } else {
        await expect(nav).toBeVisible();
        await expect(page.getByRole('button', { name: 'Buka menu utama' })).toBeHidden();
    }
});

test('filters align and card metadata stays inside each card without overlap', async ({ page }, info) => {
    await page.goto('/events?as=user');
    if (page.viewportSize().width >= 1024) {
        const boxes = await Promise.all(['search', 'category', 'budget'].map(id => page.locator(`#${id}`).boundingBox()));
        expect(Math.max(...boxes.map(b => b.y)) - Math.min(...boxes.map(b => b.y))).toBeLessThan(2);
    }
    for (const card of await page.locator('article:visible').all()) {
        const cardBox = await card.boundingBox();
        const distance = card.getByText(/km · jarak garis lurus/);
        await expect(distance).toBeVisible();
        const distanceBox = await distance.boundingBox();
        expect(distanceBox.y + distanceBox.height).toBeLessThanOrEqual(cardBox.y + cardBox.height);
    }
    const boxes = await page.locator('article:visible').evaluateAll(cards => cards.map(el => { const r = el.getBoundingClientRect(); return { x: r.x, y: r.y, right: r.right, bottom: r.bottom }; }));
    for (let i = 0; i < boxes.length; i++) for (let j = i + 1; j < boxes.length; j++) {
        const a = boxes[i], b = boxes[j];
        expect(a.right <= b.x || b.right <= a.x || a.bottom <= b.y || b.bottom <= a.y).toBe(true);
    }
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
    await page.screenshot({ path: info.outputPath('catalog-layout.png'), fullPage: true });
    await page.goto('/?as=user');
    await expect(page.locator('article:visible ul[aria-label="Alasan pilihan"]')).toHaveCount(3);
    const cardsBottom = await page.locator('article:visible').evaluateAll(cards => Math.max(...cards.map(card => card.getBoundingClientRect().bottom)));
    const scenario = await page.getByLabel('Coba jumlah pilihan').boundingBox();
    expect(scenario.y).toBeGreaterThan(cardsBottom);
    await page.screenshot({ path: info.outputPath('home-layout.png'), fullPage: true });
});
