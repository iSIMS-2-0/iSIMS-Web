<?php

class ValidationService {
    
    public static function required($value): bool {
        return !empty(trim($value));
    }

    public static function email($email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function minLength($value, int $minLength): bool {
        return strlen(trim($value)) >= $minLength;
    }

    public static function maxLength($value, int $maxLength): bool {
        return strlen(trim($value)) <= $maxLength;
    }

    public static function numeric($value): bool {
        return is_numeric($value);
    }

    public static function studentNumber($studentNumber): bool {
        // Assuming student number should be exactly 9 digits
        return preg_match('/^\d{9}$/', $studentNumber);
    }

    public static function mobileNumber($mobile): bool {
        // Philippine mobile number format (09xxxxxxxxx or +639xxxxxxxxx)
        return preg_match('/^(\+639|09)\d{9}$/', $mobile);
    }

    public static function validateArray(array $data, array $rules): array {
        $errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? '';
            
            foreach ($fieldRules as $rule => $parameter) {
                $isValid = true;
                
                switch ($rule) {
                    case 'required':
                        $isValid = self::required($value);
                        break;
                    case 'email':
                        $isValid = empty($value) || self::email($value);
                        break;
                    case 'min_length':
                        $isValid = empty($value) || self::minLength($value, $parameter);
                        break;
                    case 'max_length':
                        $isValid = self::maxLength($value, $parameter);
                        break;
                    case 'numeric':
                        $isValid = empty($value) || self::numeric($value);
                        break;
                    case 'student_number':
                        $isValid = self::studentNumber($value);
                        break;
                    case 'mobile_number':
                        $isValid = empty($value) || self::mobileNumber($value);
                        break;
                }
                
                if (!$isValid) {
                    $errors[$field][] = ucfirst(str_replace('_', ' ', $rule)) . ' validation failed';
                }
            }
        }
        
        return $errors;
    }

    public static function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([self::class, 'sanitizeInput'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}
