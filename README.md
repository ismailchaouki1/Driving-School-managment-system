# 🚗 Clario — Driving School Management System

[![Laravel](https://img.shields.io/badge/Laravel-13.x-red.svg)](https://laravel.com)
[![React](https://img.shields.io/badge/React-19.x-blue.svg)](https://reactjs.org)
[![Stripe](https://img.shields.io/badge/Stripe-Integrated-purple.svg)](https://stripe.com)
[![MailTrap](https://img.shields.io/badge/MailTrap-Email%20Testing-orange.svg)](https://mailtrap.io)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📋 Description

**Clario** is a comprehensive web-based driving school management system built with **Laravel** (backend) and **React.js** (frontend). It enables driving school administrators and instructors to efficiently manage students, vehicles, sessions, payments, and generate insightful statistics.

---

## ✨ Key Features

| Module | Features |
|--------|----------|
| 👨‍🎓 **Students** | CRUD, payment tracking, history, Excel/PDF export, receipt printing |
| 🚗 **Vehicles** | Maintenance tracking, incident reporting, status monitoring, mileage |
| 👨‍🏫 **Instructors** | Scheduling, availability, evaluations, commission tracking |
| 📅 **Sessions** | Code/Driving lessons, calendar view, real-time status, payments |
| 💳 **Payments** | Multiple methods, PDF receipts, balance tracking, history |
| 📊 **Statistics** | KPIs, charts, exportable reports, revenue trends |
| 🔐 **Auth** | Sanctum API, multi-tenancy, Stripe subscriptions |
| 📧 **Emails** | MailTrap testing, notifications, password reset |

---

## 🛠 Tech Stack

### Backend

| Technology | Version | Purpose |
|------------|---------|---------|
| Laravel | 13.x | PHP Framework |
| MySQL | 9.x | Database |
| Laravel Sanctum | — | API Authentication |
| Stripe PHP SDK | — | Payments |
| MailTrap | — | Email Testing |
| Maatwebsite Excel | — | Excel Export |
| Barryvdh DomPDF | — | PDF Export |

### Frontend

| Technology | Version | Purpose |
|------------|---------|---------|
| React.js | 19.x | UI Framework |
| Vite.js | 4.x | Build Tool |
| SCSS | — | Styling |
| GSAP | 3.x | Animations |
| Axios | — | API Requests |
| Lucide React | — | Icons |
| React Router DOM | 6.x | Navigation |

---

## 📁 Project Structure

```
Auto-Ecole-App/
├── clario-api/                         # Laravel Backend
│   ├── app/
│   │   ├── Http/Controllers/Api/
│   │   │   ├── AuthController.php
│   │   │   ├── StudentController.php
│   │   │   ├── InstructorController.php
│   │   │   ├── VehicleController.php
│   │   │   ├── SessionController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── StatisticsController.php
│   │   │   ├── StripeController.php
│   │   │   └── PasswordResetController.php
│   │   │   └── ...
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   ├── Student.php
│   │   │   ├── Instructor.php
│   │   │   ├── Vehicle.php
│   │   │   ├── Session.php
│   │   │   ├── Payment.php
│   │   │   ├── Subscription.php
│   │   │   └── PendingUser.php
│   │   ├── Mail/
│   │   │   └── PasswordResetMail.php
│   │   └── Traits/
│   │       └── MultiTenantTrait.php
│   ├── database/
│   │   └── migrations/
│   ├── resources/views/emails/
│   │   └── password-reset.blade.php
│   ├── routes/
│   │   └── api.php
│   └── .env
│
└── clario-app/                         # React Frontend
    ├── src/
    │   ├── components/
    │   │   ├── PricingSection.jsx
    │   │   ├── Checkout.jsx
    │   │   ├── Login.jsx
    │   │   └── SignUp.jsx
    │   │   └── ...
    │   ├── pages/
    │   │   ├── System/
    │   │   │   ├── MainLayout.jsx
    │   │   │   ├── Dashboard.jsx
    │   │   │   ├── Students.jsx
    │   │   │   ├── Sessions.jsx
    │   │   │   ├── Vehicles.jsx
    │   │   │   ├── Instructors.jsx
    │   │   │   ├── Payments.jsx
    │   │   │   └── Statistics.jsx
    │   │   └── auth/
    │   │       ├── LoginPage.jsx
    │   │       └── SignUpPage.jsx
    │   │       └── ...
    │   ├── contexts/
    │   │   ├── NotificationContext.jsx
    │   │   └── AuthContext.jsx
    │   │   └── ...
    │   ├── services/
    │   │   ├── axios.js
    │   │   └── notificationService.js
    │   └── styles/
    │       ├── System/
    │       └── *.scss
    ├── public/
    │   └── sounds/
    │       └── notification.mp3
    └── .env
```

---

## 🚀 Installation

### Prerequisites

- PHP >= 8.1
- Node.js >= 18
- MySQL >= 8.0
- Composer
- Git

### 1. Clone the Repository

```bash
git clone https://github.com/ismailchaouki1/Driving-School-managment-system.git
```

### 2. Backend Setup (Laravel)

```bash
cd clario-api

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Optional: seed test data
php artisan db:seed

# Start the server
php artisan serve
```

> Configure your database in `.env`:
> ```
> DB_DATABASE=clario_db
> DB_USERNAME=root
> DB_PASSWORD=
> ```

### 3. Frontend Setup (React)

```bash
# Open a new terminal
cd app

# Install dependencies
npm install

# Copy environment file
cp .env.example .env

# Start the dev server
npm run dev
```

> Configure your `.env`:
> ```
> VITE_API_URL=http://localhost:8000/api
> VITE_STRIPE_PUBLIC_KEY=pk_test_xxx
> ```

---

## 📧 MailTrap Configuration

MailTrap captures emails without delivering them to real recipients — ideal for development.

**Steps:**

1. Create an account at [mailtrap.io](https://mailtrap.io)
2. Create a free inbox (500 emails/month)
3. Copy your SMTP credentials into `.env`

**Laravel `.env`:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@clario.com
MAIL_FROM_NAME="Clario Driving School"
FRONTEND_URL=http://localhost:5173
```

**Email Template** — `resources/views/emails/password-reset.blade.php`:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; }
        .header { background: linear-gradient(135deg, #1a1a2e, #16213e); padding: 30px; text-align: center; }
        .logo { font-size: 28px; font-weight: bold; color: #8cff2e; }
        .content { padding: 40px; }
        .btn { display: inline-block; background: #8cff2e; color: #000; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-weight: bold; margin: 20px 0; }
        .footer { padding: 20px; text-align: center; border-top: 1px solid #e2e8f0; color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="logo">Clario</div>
                <h1>Reset Your Password</h1>
            </div>

            <p>Hello <strong>{{ $name }}</strong>,</p>

            <p>You recently requested to reset your password for your Clario account. Click the button below to reset it.</p>

            <div style="text-align: center;">
                <a href="{{ $reset_url }}" class="button">Reset Password</a>
            </div>

            <div class="info">
                <strong>✨ Link valid for 60 minutes</strong>
            </div>

            <div class="warning">
                <strong>⚠️ Didn't request this?</strong><br>
                If you didn't request a password reset, please ignore this email or contact support if you have concerns.
            </div>

            <p style="margin-top: 20px; font-size: 13px;">
                If the button doesn't work, copy and paste this link into your browser:
            </p>
            <p style="word-break: break-all; font-size: 12px; color: #666; background: #f8f9fa; padding: 10px; border-radius: 6px;">
                {{ $reset_url }}
            </p>

            <div class="footer">
                <p>&copy; {{ date('Y') }} Clario Driving School. All rights reserved.</p>
                <p>This is an automated message, please do not reply to this email.</p>
            </div>
        </div>
    </div>
</body>
</html>
```

**Send Function** — `app/Http/Controllers/Api/PasswordResetController.php`:

```php
private function sendResetEmail($email, $token, $name)
{
    // Validate email
    if (empty($email)) {
        throw new \Exception('Email address is required');
    }

    $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
    $resetUrl = $frontendUrl . '/reset-password?token=' . $token . '&email=' . urlencode($email);

    $data = [
        'name' => $name ?? 'User',
        'reset_url' => $resetUrl,
        'email' => $email,
        'token' => $token,
        'year' => date('Y')
    ];

    Mail::send('emails.password-reset', $data, function ($message) use ($email, $name) {
        $message->to($email, $name ?? 'User')
                ->subject('Reset Your Password - Clario Driving School')
                ->from(env('MAIL_FROM_ADDRESS', 'noreply@clario.com'), env('MAIL_FROM_NAME', 'Clario Driving School'));
    });
}
```

---

## 🔧 Environment Variables

**Backend — full `.env`:**

```env
# Application
APP_NAME=Clario
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clario_db
DB_USERNAME=root
DB_PASSWORD=

# Mail (MailTrap)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@clario.com
MAIL_FROM_NAME="Clario Driving School"

# Stripe
STRIPE_KEY=pk_test_xxx
STRIPE_SECRET=sk_test_xxx
STRIPE_WEBHOOK_SECRET=whsec_xxx
STRIPE_SUCCESS_URL=http://localhost:5173/payment-success
STRIPE_CANCEL_URL=http://localhost:5173/pricing

# Frontend
FRONTEND_URL=http://localhost:5173
```

**Frontend — `.env`:**

```env
VITE_API_URL=http://localhost:8000/api
VITE_STRIPE_PUBLIC_KEY=pk_test_xxx
```

---

## 🗄 Database Schema

### Main Tables

| Table | Description |
|-------|-------------|
| `users` | Authenticated users |
| `students` | Enrolled students |
| `instructors` | School instructors |
| `vehicles` | Fleet management |
| `driving_sessions` | Code & driving sessions |
| `payments` | All payment records |
| `subscriptions` | Stripe subscriptions |
| `pending_users` | Users awaiting payment |
| `password_reset_tokens` | Reset token storage |

### Relationships

```
users.id        → students.user_id        (onDelete: cascade)
users.id        → instructors.user_id     (onDelete: cascade)
users.id        → vehicles.user_id        (onDelete: cascade)
students.id     → sessions.student_id     (onDelete: set null)
instructors.id  → sessions.instructor_id  (onDelete: cascade)
vehicles.id     → sessions.vehicle_id     (onDelete: set null)
students.id     → payments.student_id
users.id        → subscriptions.user_id
```

### Migration Commands

```bash
php artisan migrate                  # Run all migrations
php artisan migrate:rollback         # Rollback last batch
php artisan migrate:reset            # Rollback all
php artisan migrate:refresh          # Reset + remigrate
php artisan migrate:refresh --seed   # Reset + remigrate + seed
```

---

## 🔐 Authentication

### API Routes

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/signup` | ❌ | Register (creates pending user) |
| POST | `/api/login` | ❌ | Login |
| POST | `/api/auth/activate-and-login` | ❌ | Activate after Stripe payment |
| GET | `/api/me` | ✅ | Get authenticated user |
| POST | `/api/logout` | ✅ | Logout |
| POST | `/api/password/email` | ❌ | Send reset link |
| POST | `/api/password/reset` | ❌ | Reset password |

### Route Protection

```php
// routes/api.php

// ==================== PUBLIC ROUTES ====================
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/activate-and-login', [AuthController::class, 'activateAndLogin']); 

// Stripe public routes
Route::post('/stripe/create-checkout-session', [StripeController::class, 'createCheckoutSession']);
Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook'])->name('stripe.webhook');

// Password reset routes
Route::post('/password/email', [PasswordResetController::class, 'sendResetLink']);
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);
Route::post('/password/verify-token', [PasswordResetController::class, 'verifyToken']);

// ==================== PROTECTED ROUTES ====================
Route::middleware('auth:sanctum')->group(function () {

    // AUTH ROUTES
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/preferences', [ProfileController::class, 'updatePreferences']);

    // Stripe subscription routes (authenticated)
    Route::post('/stripe/cancel-subscription', [StripeController::class, 'cancelSubscription']);
    Route::get('/stripe/subscription-status', [StripeController::class, 'getSubscriptionStatus']);

    // STUDENT ROUTES
    Route::apiResource('students', StudentController::class);
    Route::get('/students/export/excel', [StudentController::class, 'exportExcel']);
    Route::get('/students/export/pdf', [StudentController::class, 'exportPdf']);
    Route::get('/students/{student}/receipt', [StudentController::class, 'printReceipt']);
    Route::post('/students/{student}/add-payment', [StudentController::class, 'addPayment']);
    Route::get('/students/{student}/payment-history', [StudentController::class, 'getPaymentHistory']);

    // INSTRUCTOR ROUTES
    Route::apiResource('instructors', InstructorController::class);
    Route::get('/instructors/export/excel', [InstructorController::class, 'exportExcel']);
    Route::get('/instructors/export/pdf', [InstructorController::class, 'exportPdf']);

    // VEHICLE ROUTES
    Route::apiResource('vehicles', VehicleController::class);
    Route::post('/vehicles/{id}/maintenance', [VehicleController::class, 'addMaintenance']);
    Route::post('/vehicles/{id}/documents', [VehicleController::class, 'addDocument']);
    Route::post('/vehicles/{id}/incidents', [VehicleController::class, 'addIncident']);
    Route::get('/vehicles/export/excel', [VehicleController::class, 'exportExcel']);
    Route::get('/vehicles/export/csv', [VehicleController::class, 'exportCsv']);
    Route::get('/vehicles/export/pdf', [VehicleController::class, 'exportPdf']);
    Route::get('/vehicles/{id}/export', [VehicleController::class, 'exportVehiclePdf']);
    Route::get('/vehicles/update-maintenance-status', [VehicleController::class, 'updateMaintenanceStatus']);
    Route::post('/vehicles/{id}/complete-maintenance', [VehicleController::class, 'completeMaintenance']);
    Route::post('/vehicles/{id}/resolve-incident', [VehicleController::class, 'resolveIncident']);

    // SESSION ROUTES
    Route::apiResource('sessions', SessionController::class);
    Route::get('/sessions/calendar', [SessionController::class, 'getCalendarSessions']);
    Route::get('/sessions/upcoming', [SessionController::class, 'getUpcoming']);
    Route::get('/sessions/today', [SessionController::class, 'getTodaySessions']);
    Route::get('/sessions/date/{date}', [SessionController::class, 'getByDate']);
    Route::get('/sessions/export/excel', [SessionController::class, 'exportExcel']);
    Route::get('/sessions/export/pdf', [SessionController::class, 'exportPdf']);
    Route::get('/sessions/{session}/receipt', [SessionController::class, 'printReceipt']);
    Route::get('/sessions/real-time', [SessionController::class, 'getSessionsWithRealTimeStatus']);
    Route::post('/sessions/update-status', [SessionController::class, 'updateStatusBasedOnTime']);
    Route::post('/sessions/{id}/start', [SessionController::class, 'startSession']);
    Route::post('/sessions/{id}/complete', [SessionController::class, 'completeSession']);

    // PAYMENT ROUTES
    Route::apiResource('payments', PaymentController::class);
    Route::get('/payments/export/excel', [PaymentController::class, 'exportExcel']);
    Route::get('/payments/export/pdf', [PaymentController::class, 'exportPdf']);
    Route::get('/payments/{id}/receipt', [PaymentController::class, 'exportReceipt']);

    // STATISTICS ROUTES
    Route::get('/statistics/dashboard', [StatisticsController::class, 'getDashboardStats']);
    Route::get('/statistics/revenue-trends', [StatisticsController::class, 'getRevenueTrends']);
    Route::get('/statistics/session-analytics', [StatisticsController::class, 'getSessionAnalytics']);
    Route::get('/statistics/student-registrations', [StatisticsController::class, 'getStudentRegistrations']);
    Route::get('/statistics/export-excel', [StatisticsController::class, 'exportExcel']);
    Route::get('/statistics/export-pdf', [StatisticsController::class, 'exportPdf']);
});

```

---

## 💳 Stripe Payments

### Subscription Flow

```
1. Sign Up      →  Create pending user in DB
2. Checkout     →  Create Stripe Checkout Session
3. Payment      →  User completes payment on Stripe
4. Redirect     →  Stripe redirects to /payment-success?session_id=...
5. Activation   →  Backend verifies session & activates account
6. Auto-login   →  Token issued, user redirected to Dashboard
```

### Test Cards

| Scenario | Card Number | Expiry | CVC |
|----------|-------------|--------|-----|
| ✅ Successful payment | `4242 4242 4242 4242` | 12/34 | 123 |
| 🔐 3D Secure required | `4000 0025 0000 3155` | 12/34 | 123 |
| ❌ Card declined | `4000 0000 0000 0002` | 12/34 | 123 |
| ⚠️ Insufficient funds | `4000 0000 0000 9995` | 12/34 | 123 |

### Webhook (Development)

```bash
stripe listen --forward-to localhost:8000/api/stripe/webhook
```

---

## 📊 API Endpoints

### Students

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/students` | List all students |
| POST | `/api/students` | Create student |
| GET | `/api/students/{id}` | Get student details |
| PUT | `/api/students/{id}` | Update student |
| DELETE | `/api/students/{id}` | Delete student |
| POST | `/api/students/{id}/add-payment` | Add a payment |
| GET | `/api/students/{id}/payment-history` | Payment history |
| GET | `/api/students/export/excel` | Export to Excel |
| GET | `/api/students/export/pdf` | Export to PDF |
| GET | `/api/students/{id}/receipt` | Print receipt |

### Sessions

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/sessions` | List all sessions |
| POST | `/api/sessions` | Create session |
| GET | `/api/sessions/calendar` | Calendar view |
| GET | `/api/sessions/today` | Today's sessions |
| POST | `/api/sessions/{id}/start` | Start session |
| POST | `/api/sessions/{id}/complete` | Complete session |
| GET | `/api/sessions/export/excel` | Export to Excel |
| GET | `/api/sessions/export/pdf` | Export to PDF |

### Vehicles

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/vehicles` | List all vehicles |
| POST | `/api/vehicles` | Add vehicle |
| PUT | `/api/vehicles/{id}` | Update vehicle |
| DELETE | `/api/vehicles/{id}` | Delete vehicle |
| POST | `/api/vehicles/{id}/maintenance` | Log maintenance |
| POST | `/api/vehicles/{id}/incidents` | Log incident |
| POST | `/api/vehicles/{id}/complete-maintenance` | Complete maintenance |
| GET | `/api/vehicles/export/excel` | Export to Excel |
| GET | `/api/vehicles/export/pdf` | Export to PDF |

---

## 🧪 Testing

### Backend

```bash
php artisan test                                   # Run all tests
php artisan test --filter=StudentControllerTest    # Run specific test
php artisan test --coverage                        # With coverage report
```

### Frontend

```bash
npm run test           # Run tests
npm run test:watch     # Watch mode
npm run test:coverage  # Coverage report
```

---

## 📱 Useful Commands

### Backend

```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Debugging
php artisan route:list
php artisan tinker

# Code generation
php artisan make:controller Api/ExampleController --api
php artisan make:model Example -m
```

### Frontend

```bash
npm run build    # Production build
npm run preview  # Preview production build
npm run lint     # Run ESLint
npm run format   # Format with Prettier
```

---

## 🐛 Troubleshooting

### `No such price: 'price_pro_monthly'`

Stripe prices are not configured. The app uses dynamic pricing — no static price IDs needed.

### `SQLSTATE[HY000]: Field 'stripe_session_id' doesn't have a default`

Make the column nullable in the migration:

```php
$table->string('stripe_session_id')->nullable();
```

Then run:

```bash
php artisan migrate:refresh
```

### `Route [api/students/{id}/add-payment] not found`

Add the missing route in `routes/api.php`:

```php
Route::post('/students/{student}/add-payment', [StudentController::class, 'addPayment']);
```

### `Connection refused` (MailTrap)

Verify that your `MAIL_USERNAME` and `MAIL_PASSWORD` match your MailTrap inbox SMTP credentials.

### `Swift_TransportException`

Check that all `MAIL_*` variables are correctly set in your `.env` file and run:

```bash
php artisan config:clear
```

---

## 🚀 Deployment

### Production Optimization

```bash
# Backend
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Frontend
npm run build
```

### Production `.env` Adjustments

```env
APP_ENV=production
APP_DEBUG=false

# Replace MailTrap with a real SMTP provider
MAIL_HOST=smtp.sendgrid.net
# or: smtp.mailgun.org, smtp.postmarkapp.com
```


---

## 👥 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/AmazingFeature`
3. Commit your changes: `git commit -m 'feat: Add AmazingFeature'`
4. Push to the branch: `git push origin feature/AmazingFeature`
5. Open a Pull Request

### Commit Convention

| Prefix | Purpose |
|--------|---------|
| `feat:` | New feature |
| `fix:` | Bug fix |
| `docs:` | Documentation update |
| `style:` | Code formatting |
| `refactor:` | Code refactoring |
| `test:` | Test additions |
| `chore:` | Maintenance tasks |

---

## 📄 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

## 📞 Contact

**Developer:** Ismail Chaouki

[![GitHub](https://img.shields.io/badge/GitHub-ismailchaouki1-black?logo=github)](https://github.com/ismailchaouki1)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-ismail--chaouki-blue?logo=linkedin)](https://linkedin.com/in/ismail-chaouki)

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) — PHP Framework
- [React](https://reactjs.org) — UI Library
- [Stripe](https://stripe.com) — Payment Processing
- [MailTrap](https://mailtrap.io) — Email Testing
- [GSAP](https://greensock.com/gsap) — Animations
- [Lucide Icons](https://lucide.dev) — Icon Library

---

<div align="center">

**© 2026 Clario — Complete Driving School Management Solution**

*Built with ❤️ using Laravel & React*

</div>
