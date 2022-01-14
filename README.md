# Clockission

[![Tests](https://github.com/vlasscontreras/clockission/actions/workflows/tests.yml/badge.svg)](https://github.com/vlasscontreras/clockission/actions/workflows/tests.yml)
[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/vlasscontreras/clockission/blob/main/LICENSE.md)

Export CSV files from Clockify and import them into the Mission Timecards and save about 10-20 minutes per week 😁

## ✨ Features

* Processes right from Clockify's format, no additional actions needed
* If multiple time entries result in the same Activity Type and Description, the time is added so you don't get duplicated time slips
* It's fun

## 💿 Installation

Clone the repository:

```shell
git clone git@github.com:vlasscontreras/clockission.git
```

Install the dependencies:

```shell
composer install --prefer-dist
```

Copy the `.env.example` (and update your credentials):

```shell
cp .env.example .env
```

## 🤔 How It Works?

In Clockify, make sure your time entries have the following format:

```
[Activity Type]: [Description]
```

Where **Activity Type** can be one of the following:

- Communication
- Planning
- Production
- Review

Example:

```
Production: PS-9999
```

Then, export a report from Clockify in CSV format, with whatever dates you want, and place it wherever you want. Next, use this command:

```shell
composer run-script post-slips /path/to/csv
```

Done! 😃

## 📄 License

The Clockission project is open-sourced software licensed under the [MIT license](LICENSE.md).
