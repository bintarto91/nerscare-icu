import fs from 'fs';
import path from 'path';
import Module from 'module';
import { createRequire } from 'module';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const projectRoot = path.resolve(__dirname, '..');
const outputDir = path.join(projectRoot, 'docs', 'devpost-demo');

const nodeModulesRoot = 'C:\\Users\\dwahy\\.cache\\codex-runtimes\\codex-primary-runtime\\dependencies\\node\\node_modules';
const playwrightCoreModules = path.join(nodeModulesRoot, '.pnpm', 'playwright-core@1.61.1', 'node_modules');

process.env.NODE_PATH = [nodeModulesRoot, playwrightCoreModules, process.env.NODE_PATH]
  .filter(Boolean)
  .join(path.delimiter);
Module._initPaths();

const require = createRequire(import.meta.url);
const { chromium } = require('playwright');

const baseUrl = process.env.DEMO_URL || 'https://nerscare-icu.com';
const chromePath = process.env.CHROME_PATH || 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const viewport = { width: 1280, height: 720 };

fs.mkdirSync(outputDir, { recursive: true });

function sleep(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

async function goto(page, url) {
  await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 45000 });
  await page.waitForLoadState('load', { timeout: 15000 }).catch(() => {});
  await page.waitForTimeout(1200);
}

async function caption(page, title, body = '') {
  await page.evaluate(({ title, body }) => {
    let box = document.getElementById('codex-demo-caption');
    if (!box) {
      box = document.createElement('div');
      box.id = 'codex-demo-caption';
      box.innerHTML = '<strong></strong><span></span>';
      document.body.appendChild(box);
    }

    const strong = box.querySelector('strong');
    const span = box.querySelector('span');
    strong.textContent = title;
    span.textContent = body;

    Object.assign(box.style, {
      position: 'fixed',
      left: '32px',
      bottom: '30px',
      zIndex: '2147483647',
      width: 'min(560px, calc(100vw - 64px))',
      padding: '18px 20px',
      borderRadius: '18px',
      background: 'rgba(7, 43, 52, 0.92)',
      color: '#ffffff',
      boxShadow: '0 18px 50px rgba(6, 36, 44, 0.28)',
      border: '1px solid rgba(255, 255, 255, 0.22)',
      fontFamily: 'Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
      lineHeight: '1.45',
      backdropFilter: 'blur(16px)',
    });

    Object.assign(strong.style, {
      display: 'block',
      marginBottom: body ? '6px' : '0',
      fontSize: '24px',
      fontWeight: '800',
      letterSpacing: '0',
    });

    Object.assign(span.style, {
      display: body ? 'block' : 'none',
      fontSize: '15px',
      color: '#dff7f7',
    });
  }, { title, body });
}

async function smoothScroll(page, top, duration = 900) {
  await page.evaluate(({ top, duration }) => {
    const start = window.scrollY;
    const delta = top - start;
    const startTime = performance.now();

    function step(now) {
      const progress = Math.min((now - startTime) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      window.scrollTo(0, start + delta * eased);
      if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
  }, { top, duration });
  await page.waitForTimeout(duration + 250);
}

async function clickIfVisible(page, selector) {
  const locator = page.locator(selector).first();
  if (await locator.count()) {
    await locator.click({ timeout: 5000 }).catch(() => {});
    return true;
  }
  return false;
}

async function fillPublicCalculator(page) {
  await page.evaluate(() => {
    const values = [2, 3, 2, 4, 3, 2, 3, 2, 2, 3, 2];
    const cards = Array.from(document.querySelectorAll('.question-card'));
    cards.forEach((card, index) => {
      const value = values[index] || 3;
      const input = card.querySelector(`input[type="radio"][value="${value}"]`);
      if (input) {
        input.checked = true;
        input.dispatchEvent(new Event('change', { bubbles: true }));
      }
    });
  });
}

async function showSplash(page) {
  await page.setContent(`
    <!doctype html>
    <html lang="id">
      <head>
        <meta charset="utf-8">
        <title>NersCare ICU Demo</title>
        <style>
          * { box-sizing: border-box; }
          body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #062b34;
            background:
              radial-gradient(circle at 72% 18%, rgba(23, 177, 166, .24), transparent 32%),
              linear-gradient(135deg, #eefafa 0%, #ffffff 46%, #e8f3f5 100%);
          }
          .splash {
            width: min(900px, calc(100vw - 80px));
            padding: 64px;
            border-radius: 32px;
            background: rgba(255,255,255,.86);
            border: 1px solid rgba(5, 114, 116, .18);
            box-shadow: 0 30px 90px rgba(6, 36, 44, .16);
            text-align: center;
          }
          .mark {
            width: 96px;
            height: 96px;
            margin: 0 auto 24px;
            border-radius: 28px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #087b78, #16a799);
            color: white;
            font-size: 42px;
            font-weight: 900;
            box-shadow: 0 18px 44px rgba(8, 123, 120, .24);
          }
          h1 {
            margin: 0 0 12px;
            font-size: 54px;
            letter-spacing: 0;
          }
          p {
            margin: 0 auto;
            max-width: 650px;
            font-size: 22px;
            line-height: 1.5;
            color: #52677a;
          }
        </style>
      </head>
      <body>
        <main class="splash">
          <div class="mark">ICU</div>
          <h1>NersCare ICU</h1>
          <p>AI-assisted loneliness assessment and education for ICU patients.</p>
        </main>
      </body>
    </html>
  `);
  await page.waitForTimeout(2200);
}

async function main() {
  const browser = await chromium.launch({
    headless: true,
    executablePath: chromePath,
    args: ['--window-size=1280,720'],
  });

  const context = await browser.newContext({
    viewport,
    recordVideo: { dir: outputDir, size: viewport },
  });

  const page = await context.newPage();

  await showSplash(page);
  await goto(page, baseUrl);
  await caption(
    page,
    'NersCare ICU',
    'Web assessment loneliness dan edukasi untuk pasien ICU, perawat, keluarga, dan tim penelitian.'
  );
  await page.waitForTimeout(4200);

  await caption(
    page,
    'Alur Awal Yang Mudah Dipahami',
    'Pengunjung langsung melihat tujuan sistem, tombol kalkulator, booklet edukasi, dan akses login petugas.'
  );
  await smoothScroll(page, 560);
  await page.waitForTimeout(2600);

  await page.evaluate(() => document.getElementById('booklet-edukasi')?.scrollIntoView({ behavior: 'smooth', block: 'center' }));
  await page.waitForTimeout(1800);
  await caption(
    page,
    'Booklet Edukasi Interaktif',
    'Booklet bisa dibaca seperti buku, berpindah halaman otomatis, dan tetap bisa dikontrol manual.'
  );
  await page.waitForTimeout(4800);
  await clickIfVisible(page, '#nextBookletBtn');
  await page.waitForTimeout(1800);
  await clickIfVisible(page, '#nextBookletBtn');
  await page.waitForTimeout(2600);

  await goto(page, `${baseUrl}/cek-loneliness`);
  await caption(
    page,
    'Kalkulator Loneliness Public',
    'Pengunjung dapat mencoba simulasi edukatif tanpa login dan tanpa menyimpan data ke database.'
  );
  await page.waitForTimeout(2500);
  await smoothScroll(page, 640);
  await fillPublicCalculator(page);
  await page.waitForTimeout(1200);
  await caption(
    page,
    'Skor, Kategori, Dan Dimensi',
    'Sistem menampilkan total skor, kategori loneliness, serta kecenderungan emotional atau social loneliness.'
  );
  await page.evaluate(() => window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' }));
  await page.waitForTimeout(4500);

  await goto(page, `${baseUrl}/login`);
  await caption(
    page,
    'Login Petugas',
    'Petugas masuk untuk mengelola data pasien, assessment resmi, hasil penilaian, dan edukasi lanjutan.'
  );
  await page.fill('input[name="email"]', 'admin@demo.com').catch(async () => {
    await page.fill('input[name="login"]', 'admin@demo.com');
  });
  await page.fill('input[name="password"]', 'password');
  await page.waitForTimeout(1200);
  await page.locator('button[type="submit"]').first().click();
  await page.waitForLoadState('domcontentloaded', { timeout: 30000 }).catch(() => {});
  await page.waitForTimeout(2200);

  await caption(
    page,
    'Dashboard Penelitian',
    'Dashboard merangkum pasien, assessment, pertanyaan, materi edukasi, dan catatan klinis untuk tim.'
  );
  await page.waitForTimeout(4200);

  await goto(page, `${baseUrl}/patients`);
  await caption(
    page,
    'Data Pasien ICU',
    'Petugas dapat melihat status kelayakan pasien sebelum assessment dilakukan.'
  );
  await page.waitForTimeout(4300);

  await goto(page, `${baseUrl}/assessment-loneliness`);
  await caption(
    page,
    'Assessment Loneliness',
    'Assessment mengikuti De Jong Gierveld Loneliness Scale dengan perhitungan total dan dimensi.'
  );
  await page.waitForTimeout(4300);

  await goto(page, `${baseUrl}/education/perawat`);
  await caption(
    page,
    'Edukasi Perawat Dan Keluarga',
    'Hasil assessment dapat dilanjutkan menjadi rekomendasi edukasi yang lebih mudah dipahami.'
  );
  await page.waitForTimeout(4300);

  await goto(page, `${baseUrl}/`);
  await caption(
    page,
    'Siap Untuk Demo Hackathon',
    'NersCare ICU menggabungkan screening loneliness, dokumentasi, dan edukasi pendukung dalam satu alur.'
  );
  await page.waitForTimeout(4200);

  await context.close();
  await browser.close();

  const videos = fs.readdirSync(outputDir)
    .filter((name) => name.endsWith('.webm'))
    .map((name) => ({
      name,
      time: fs.statSync(path.join(outputDir, name)).mtimeMs,
    }))
    .sort((a, b) => b.time - a.time);

  const latest = videos[0]?.name;
  if (latest) {
    const source = path.join(outputDir, latest);
    const target = path.join(outputDir, 'nerscare-icu-devpost-demo.webm');
    if (source !== target) {
      fs.copyFileSync(source, target);
    }
    console.log(target);
  } else {
    console.error('Video file was not generated.');
    process.exit(1);
  }
}

main().catch((error) => {
  console.error(error.stack || error.message);
  process.exit(1);
});
