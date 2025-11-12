# Centre Al Nojom - Educational Center Management System

A comprehensive Laravel-based management system for educational centers, designed to handle student enrollment, teacher management, class scheduling, payment tracking, and revenue reporting.

## 🚀 Features

### Core Functionality
- **Student Management**: Complete CRUD operations for student records
- **Teacher Management**: Teacher profiles with subject assignments and payment percentages
- **Class Management**: Class creation with scheduling and student enrollment
- **Subject Management**: Multilingual subject catalog with fee structures
- **Payment Tracking**: Monthly payment tracking for students and teachers
- **Revenue Reporting**: Comprehensive revenue analytics and reporting

### Advanced Features
- **Multilingual Support**: Arabic and English language support
- **Responsive Design**: Mobile-friendly interface with dark mode
- **Real-time Analytics**: Dashboard with key performance indicators
- **Bulk Operations**: Bulk payments and student management
- **Export Functionality**: Data export for reports and analytics
- **Advanced Filtering**: Search and filter capabilities across all modules

## 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 12.x
- **Database**: SQLite (development), MySQL/PostgreSQL (production)
- **Authentication**: Laravel UI with role-based access
- **Validation**: Form Request validation with custom messages
- **Localization**: Laravel localization with Arabic/English support

### Frontend
- **Styling**: Tailwind CSS with custom design system
- **JavaScript**: Vanilla ES6+ with modular architecture
- **Icons**: Heroicons SVG icons
- **Responsive**: Mobile-first responsive design

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/     # Application controllers
│   └── Requests/        # Form validation requests
├── Models/              # Eloquent models with relationships
├── Providers/           # Service providers
└── Middleware/          # Custom middleware

resources/
├── views/               # Blade templates
├── js/                  # JavaScript modules
│   └── modules/         # Modular JavaScript components
└── lang/                # Localization files

database/
├── migrations/          # Database schema migrations
├── seeders/             # Database seeders
└── factories/           # Model factories

routes/
└── web.php              # Web routes with grouped organization
```

## 🗄️ Database Schema

### Core Entities

#### Students
- Personal information (name, phone, grade)
- Enrollment date and notes
- Relationships: Subjects, Classes, Payments

#### Teachers
- Personal information and contact details
- Monthly percentage for revenue sharing
- Relationships: Subjects, Classes, Payments

#### Subjects
- Multilingual names (English/Arabic)
- Fee structure and descriptions
- Relationships: Students, Teachers, Classes

#### Classes
- Class scheduling with time slots
- Teacher and subject assignments
- Student enrollment management

#### Payments
- Monthly payment tracking
- Payment methods and status
- Revenue calculation and reporting

## 🔧 Installation & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- SQLite/MySQL/PostgreSQL

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd centre-al-nojom
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

## 🎯 Usage Guide

### Student Management
1. Navigate to Students section
2. Add new students with personal information
3. Assign subjects and classes
4. Track monthly payments and status

### Teacher Management
1. Create teacher profiles with contact details
2. Assign subjects and set payment percentages
3. Manage class assignments and schedules
4. Track teacher payments and earnings

### Payment Processing
1. Record individual or bulk payments
2. Track payment status by month
3. Generate revenue reports
4. Export payment data for accounting

### Reporting & Analytics
1. View dashboard with key metrics
2. Generate subject payment reports
3. Analyze teacher earnings
4. Export data for external analysis

## 🔒 Security Features

- **Authentication**: Laravel's built-in authentication system
- **Authorization**: Role-based access control
- **Validation**: Comprehensive form validation with custom messages
- **CSRF Protection**: Built-in CSRF token protection
- **Input Sanitization**: Automatic input trimming and validation

## 📊 Code Quality

### Code Standards
- **PHP**: Laravel Pint for code formatting
- **JavaScript**: ES6+ with modular architecture
- **CSS**: Tailwind CSS with consistent design system

### Best Practices Implemented
- **MVC Architecture**: Proper separation of concerns
- **Eloquent Relationships**: Efficient database relationships
- **Form Requests**: Dedicated validation classes
- **Route Grouping**: Organized route structure
- **Error Handling**: Comprehensive exception handling

## 🚀 Development

### Running Tests
```bash
php artisan test
```

### Code Formatting
```bash
vendor/bin/pint
```

### Database Seeding
```bash
php artisan db:seed
```

### Asset Compilation
```bash
npm run dev    # Development
npm run build  # Production
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests and code formatting
5. Submit a pull request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the documentation

---

**Built with ❤️ for educational centers**
