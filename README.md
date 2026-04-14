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
