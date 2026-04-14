# CoreOGraphy
<p align="center">
  <img src="https://pln.inf.um.es/core-o-graphy.png" width="400"/>
</p>

A lightweight PHP micro-core for building web applications with a pragmatic stack:
**AltoRouter** for routing, **Twig** for templating, **Symfony components** for developer tooling and console commands, and a simple project structure oriented to small and medium-sized applications.

## Why CoreOGraphy?

CoreOGraphy is a minimal application core designed for teams that want:

- A small and understandable codebase
- Server-side rendered applications with Twig
- Simple routing without a full-stack framework overhead
- Reusable commands and utility services
- A structure that is easy to adapt for internal tools, dashboards, and research software

## Main Components

CoreOGraphy currently integrates:

- **AltoRouter** for route definition
- **Twig** for view rendering
- **Symfony Console** for CLI commands
- **Symfony Debug / Finder / Filesystem** for utilities
- **Phinx** for database migrations
- **SwiftMailer** for email support
- **PHP i18n** utilities for localization

## Project Structure

```text
coreography/
├── cache/
├── commands/
├── controllers/
├── core/
├── css/
├── custom/
├── js/
├── lang/
├── templates/
├── .htaccess
├── composer.json
├── config.sample.php
├── index.php
├── routes.php
└── scripts.php
```

## Installation

To get started with CoreOGraphy, follow these steps:

1. Clone the repository:
```
    git clone https://github.com/NLP-UMUTeam/coreography.git  
    cd coreography
```

2. Install dependencies using Composer:
```
    composer install
```

3. Create your configuration file:
```
    cp config.sample.php config.php
```

4. Edit the configuration file:
- Open `config.php`
- Adjust the required settings (database, paths, environment variables, etc.)

5. Run the application:
- Make sure your web server points to `index.php`
- Ensure write permissions for directories like `cache/`
