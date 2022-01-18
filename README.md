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
php cm upload-slips /path/to/csv
```

Done! 😃

## RAQ (Rarely Asked Questions)

### What are the required environment variables?

All those that are present in the `.env.example` file.

---

### What are my credentials used for?

To send a request to the Mission "API" so they are assigned to your profile properly.

<details>
<summary>👀 For the curious ones... <em>(click me)</em></summary>
<br>
You can see more details about the usage of your credentials and the interaction with the Mission "API" in the <code>src/Mission/Commands/UploadSlips.php</code> and <code>src/Mission/Client.php</code> files.
</details>

---

### Where do I find the team ID?

Go the [timecards page](https://app.mission.dev/platform/time_cards) and choose your option from the **Select Team** dropdown, then open the Browser Developer Tools, go to the Console, and put the following statement:

```javascript
document.getElementById('time_slip_team_id').value
```

The output will be the team ID.

---

### Where do I find the time card ID?

Go the [timecards page](https://app.mission.dev/platform/time_cards) and open the Browser Developer Tools, go to the Console, and put the following statement:

```javascript
document.getElementById('time_card_id').value
```

The output will be the time card ID.

---

### How do I export a CSV from Clockify?

Go to **Reports** > **Detailed**, select **Team**, **Client**, **Project**, etc. and then click the **Export** dropdown and select the **Save as CSV** option.

Clockify documentation: [Customize exports](https://clockify.me/help/extra-features/customize-exports).

---

### Why?

🤷🏻‍♂️

## 📄 License

The Clockission project is open-sourced software licensed under the [MIT license](LICENSE.md).
