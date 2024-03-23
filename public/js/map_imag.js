
const puppeteer = require('puppeteer');

const mapUrl = process.argv[2];
const filePath = process.argv[3];

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.setViewport({ width: 800, height: 600 });
    await page.goto(mapUrl);
    await page.screenshot({ path: filePath });
    await browser.close();
})();
