import { defineConfig } from '@playwright/test';

export default defineConfig({
    testDir: './tests/Browser',
    fullyParallel: true,
    workers: 2,
    use: {
        baseURL: 'http://127.0.0.1:8001',
        browserName: 'chromium',
        launchOptions: process.env.PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH
            ? { executablePath: process.env.PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH }
            : {},
    },
    projects: [
        { name: 'mobile-360', use: { viewport: { width: 360, height: 800 } } },
        { name: 'tablet-768', use: { viewport: { width: 768, height: 1024 } } },
        { name: 'desktop-1280', use: { viewport: { width: 1280, height: 900 } } },
    ],
    webServer: {
        command: 'php artisan serve --no-reload --host=127.0.0.1 --port=8001',
        url: 'http://127.0.0.1:8001/up',
        reuseExistingServer: false,
    },
});
