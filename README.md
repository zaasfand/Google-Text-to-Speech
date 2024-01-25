# Laravel PhpWord Project

This project is a Laravel application that utilizes the PhpWord library to generate Word documents with Unicode characters.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## Introduction

This Laravel project demonstrates how to use the PhpWord library to generate Word documents, especially when dealing with Unicode characters. It serves as a foundation for creating documents with multilingual content.

## Features

- Integration with PhpWord for Word document generation.
- Support for Unicode characters and multilingual content.

## Requirements

- PHP (>=7.0)
- Laravel (>=5.6)
- PhpWord library

## Installation

Follow these steps to install the project:

```bash
# Clone the repository
git clone https://github.com/zaasfand/Google-Text-to-Speech

# Change into the project directory
cd your-project

# Install dependencies
composer install

# Configure .env file
cp .env.example .env
php artisan key:generate
