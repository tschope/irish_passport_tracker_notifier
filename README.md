# Irish Passport Tracking Notifier

This project is a Laravel-based tool that helps users track the status of their Irish passport application and receive updates via email. The application scrapes the official Irish Passport Tracking website and notifies users twice daily about the current status of their application.

---

## Features

- **Automated Passport Tracking:**
    - Retrieves the current status of a user's passport application from the official Irish Passport Tracking website.

- **Email Notifications:**
    - Sends email updates with the latest status twice a day: once in the morning and once in the evening.

- **Error Handling:**
    - Includes detailed logging and error handling for failed requests or unexpected website changes.

---

## Prerequisites

- Laravel 11+
- Composer
- A valid email account for sending notifications (e.g., Gmail, Outlook)

---

## Installation

### 1. Clone the Repository
```bash
git clone https://github.com/tschope/irish_passport_tracker_notifier.git
cd irish-passport-tracking-notifier
```

### 2. Set Up Laravel Application
```bash
cd laravel-app
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
```

### 4. Configure Environment Variables

In the Laravel `.env` file, update:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Passport Notifier"
```

### 5. Run Migrations
```bash
php artisan migrate
```

---

## Usage

### 1. Schedule the Laravel Command

To automatically check and send emails twice a day, add the Laravel command to your crontab:
```bash
php artisan schedule:work
```
Or manually run the command:
```bash
php artisan passport:track
```

---

## Troubleshooting

1. **Error: `View [view.name] not found`**
    - Run the following commands to clear caches:
      ```bash
      php artisan view:clear
      php artisan config:clear
      ```
    - Ensure the `emails/status.blade.php` file exists in the `resources/views` directory.

2. **Error: `500 Internal Server Error`**
    - Check if the cookies and `__RequestVerificationToken` are correctly set in the Python script.
    - Confirm that the Irish Passport Tracking website hasn't changed its structure.

3. **Emails Not Sending**
    - Verify SMTP configuration in `.env` files.
    - Check Laravel logs for errors:
      ```bash
      tail -f storage/logs/laravel.log
      ```

---

## Contributing

Contributions are welcome! Feel free to open issues or submit pull requests for enhancements or bug fixes.

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## Acknowledgments

- [Laravel Documentation](https://laravel.com/docs)
- [Python Requests Library](https://docs.python-requests.org/en/latest/)
- [BeautifulSoup Documentation](https://www.crummy.com/software/BeautifulSoup/bs4/doc/)
