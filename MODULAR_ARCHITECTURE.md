# iSIMS Modular Architecture Documentation

## Overview
The iSIMS project has been refactored to implement proper MVC architecture with modular services. This document outlines the new structure and how to use it.

## Directory Structure

```
src/
├── Controllers/         # Handle HTTP requests and coordinate between Models and Views
│   ├── BaseController.php          # Abstract base controller with common functionality
│   ├── AuthController.php          # Authentication and login
│   ├── HomePageController.php      # Dashboard and home page
│   ├── ProfileController.php       # Student profile, grades, schedule
│   ├── PaymentController.php       # Payment history and online payments
│   ├── CurriculumController.php    # Curriculum display
│   ├── RegistrationController.php  # Registration management
│   └── ConcernsController.php      # Concerns and feedback
├── Models/              # Data access layer
│   ├── User.php
│   ├── Curriculum.php
│   ├── Grades.php
│   ├── Registration.php
│   ├── Schedule.php
│   ├── Subjects.php
│   └── Sections.php
├── Views/               # Presentation layer (HTML/PHP templates)
│   ├── Login.php
│   ├── HomePage.php
│   ├── Profile/
│   ├── Payment/
│   └── Registration/
├── Services/            # Business logic and utilities
│   ├── AuthService.php           # Authentication management
│   ├── DatabaseService.php       # Database connection singleton
│   ├── PaymentService.php        # Payment calculations and operations
│   ├── Router.php               # Route management
│   ├── ConfigService.php        # Configuration management
│   └── ValidationService.php    # Input validation
└── Helpers/             # Utility functions
    ├── GradeHelpers.php
    └── SchoolYearHelpers.php
```

## Key Improvements

### 1. Service Layer
- **AuthService**: Centralized authentication management
- **PaymentService**: Business logic for payment calculations and file uploads
- **DatabaseService**: Singleton pattern for database connections
- **ConfigService**: Configuration management
- **ValidationService**: Input validation utilities

### 2. Proper MVC Separation
- Controllers only handle HTTP requests and coordinate between services
- Business logic moved to appropriate services
- Database operations abstracted through services
- Views remain clean presentation layer

### 3. Router System
- Centralized routing in `Router.php`
- Easy to add new routes
- Clean URL handling

### 4. Authentication Management
- Session management centralized in `AuthService`
- Consistent authentication checks across controllers
- Easy to implement additional security features

## Usage Examples

### Adding a New Route
```php
// In Router.php
$this->addRoute('new_page', 'NewController', 'showPage');
```

### Using Authentication Service
```php
// In any controller
AuthService::requireAuth();
$currentUser = AuthService::getCurrentUser();
```

### Using Payment Service
```php
// Calculate tuition
$paymentService = new PaymentService($pdo);
$calculation = $paymentService->calculateTuition($subjects);
```

### Using Validation Service
```php
// Validate input
$rules = [
    'email' => ['required' => true, 'email' => true],
    'student_number' => ['required' => true, 'student_number' => true]
];
$errors = ValidationService::validateArray($_POST, $rules);
```

## Benefits of This Architecture

1. **Maintainability**: Code is organized into logical modules
2. **Reusability**: Services can be used across multiple controllers
3. **Testability**: Services can be easily unit tested
4. **Scalability**: Easy to add new features without breaking existing code
5. **Security**: Centralized authentication and validation
6. **Performance**: Database connection pooling through singleton pattern

## Migration Notes

- All controllers now extend from proper architecture patterns
- Session management is handled by `AuthService`
- Database connections are managed by `DatabaseService`
- Business logic is separated into appropriate services
- The existing functionality remains unchanged from the user perspective

## Future Enhancements

1. Implement caching service
2. Add logging service
3. Implement email service for notifications
4. Add API endpoints for mobile app integration
5. Implement role-based access control
6. Add audit logging for administrative actions
