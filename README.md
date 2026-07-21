# NersCare ICU

AI-assisted loneliness assessment and education for ICU patients, nurses, and families.

## Overview

NersCare ICU is a web-based assessment and education platform designed to support ICU nurses, research teams, and patient families. The system helps structure loneliness assessment workflows, calculate scores, show interpretation categories, manage patient history, and provide educational material for follow-up support.

This project is intended as a research-support and educational assessment tool. It is not a medical diagnosis tool and should not replace clinical judgement.

## Key Features

- Public landing page for project introduction.
- Public loneliness calculator for educational simulation.
- Interactive booklet section for patient-family education.
- Staff login for admin, nurse, and family roles.
- Patient data management for ICU assessment readiness.
- Structured loneliness assessment workflow.
- Total score, loneliness category, and dominant loneliness type display.
- Emotional loneliness and social loneliness assessment support.
- Assessment history and result review.
- Education content for nurses and families.
- PWA support for mobile-friendly access.

## Tech Stack

- Laravel
- PHP
- MySQL
- Blade
- HTML5
- CSS3
- JavaScript
- Progressive Web App support

## Demo

Production demo:

```text
https://nerscare-icu.com
```

## Local Installation

1. Clone the repository.

```bash
git clone https://github.com/USERNAME/nerscare-icu.git
cd nerscare-icu
```

2. Install PHP dependencies.

```bash
composer install
```

3. Copy the environment file.

```bash
cp .env.example .env
```

4. Configure database credentials in `.env`.

```env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Generate the application key.

```bash
php artisan key:generate
```

6. Run migrations and seeders.

```bash
php artisan migrate --seed
```

7. Start the local server.

```bash
php artisan serve
```

8. Open the local app.

```text
http://127.0.0.1:8000
```

## Testing Instructions For Judges

1. Open the production demo link.
2. Review the landing page and public information.
3. Try the public loneliness calculator.
4. Review the booklet education section.
5. Login with demo credentials if provided privately.
6. Review patient data, assessment workflow, scoring results, history, and education pages.

If credentials are required, they can be provided privately to judges or organizers.

## Use Of Codex And GPT-5.6

Codex and GPT-5.6 were used to assist with:

- Laravel feature implementation.
- UI refinement and responsive design review.
- PWA manifest and service worker setup.
- Project documentation drafting.
- Hackathon submission preparation.
- README writing and copy review.

All generated or assisted content was reviewed and adapted for the project context.

## Project Context

ICU patients may experience emotional loneliness, social loneliness, uncertainty, and limited interaction with others during treatment. NersCare ICU was built to help nurses and research teams document assessment data in a structured way and provide educational support for families.

## License

This project is prepared for hackathon and research demonstration purposes.
