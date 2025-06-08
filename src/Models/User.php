
<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
<<<<<<< Updated upstream

    // Auto-generate unique student number
    private function generateStudentNumber($yearPrefix = null) {
        $year = $yearPrefix ?? date('Y');
        $prefix = $year . '01'; // 01 is arbitrary (can represent campus/department)

        $stmt = $this->pdo->prepare('SELECT student_number FROM students WHERE student_number LIKE :prefix ORDER BY student_number DESC LIMIT 1');
        $stmt->execute(['prefix' => $prefix . '%']);
        $last = $stmt->fetchColumn();

        if ($last) {
            $lastNum = (int)substr($last, -3); // get last 3 digits
            $newCounter = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newCounter = '000';
        }

        return $prefix . $newCounter;
    }

    public function findByStudentNumber($student_number) {
        $stmt = $this->pdo->prepare('SELECT * FROM students WHERE student_number = :student_number');
        $stmt->execute(['student_number' => $student_number]);
        return $stmt->fetch();
    }

    public function findMedicalHistoryByID($medical_historyid) {
        $stmt = $this->pdo->prepare('SELECT * FROM medical_history WHERE id = :medical_historyid');
        $stmt->execute(['medical_historyid' => $medical_historyid]);
        return $stmt->fetch();
    }

    public function findFamilyInfoByID($family_info_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM family_info WHERE id = :family_info_id');
        $stmt->execute(['family_info_id' => $family_info_id]);
        return $stmt->fetch();
    }

   public function createCompleteUser($studentData, $familyData, $medicalData) {
    $this->pdo->beginTransaction();
    try {
        // Insert family info
        $stmt = $this->pdo->prepare("INSERT INTO family_info (mother_name, father_name, mother_mobile_number, father_mobile_number, mother_email, father_email, emergency_contact, other_contact_name, other_contact_mobilenum, other_contact_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $familyData['mother_name'],
            $familyData['father_name'],
            $familyData['mother_mobile_number'],
            $familyData['father_mobile_number'],
            $familyData['mother_email'],
            $familyData['father_email'],
            $familyData['emergency_contact'],
            $familyData['other_contact_name'],
            $familyData['other_contact_mobilenum'],
            $familyData['other_contact_email']
        ]);
        $family_info_id = $this->pdo->lastInsertId();

        // Insert medical history
        $stmt = $this->pdo->prepare("INSERT INTO medical_history (comorb, allergies) VALUES (?, ?)");
        $stmt->execute([
            $medicalData['comorb'],
            $medicalData['allergies']
        ]);
        $medical_historyid = $this->pdo->lastInsertId();

        // Generate student number
        $studentData['student_number'] = $this->generateStudentNumber();

        // Hash password
        $studentData['password_hash'] = password_hash($studentData['password_hash'], PASSWORD_BCRYPT);

        // Insert student
        $stmt = $this->pdo->prepare("INSERT INTO students (student_number, name, program, sex, gender_disclosure, mobile, landline, email, lot_blk, street, zip_code, city_municipality, country, password_hash, family_info_id, medical_historyid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $studentData['student_number'],
            $studentData['name'],
            $studentData['program'],
            $studentData['sex'],
            $studentData['gender_disclosure'],
            $studentData['mobile'],
            $studentData['landline'],
            $studentData['email'],
            $studentData['lot_blk'],
            $studentData['street'],
            $studentData['zip_code'],
            $studentData['city_municipality'],
            $studentData['country'],
            $studentData['password_hash'],
            $family_info_id,
            $medical_historyid
        ]);

        $this->pdo->commit();
        return $studentData['student_number'];
    } catch (Exception $e) {
        $this->pdo->rollBack();
        throw $e;
    }
}
=======
    
public function findByStudentNumber($student_number) {
    $stmt = $this->pdo->prepare('SELECT * FROM students WHERE student_number = :student_number');
    $stmt->execute(['student_number' => $student_number]);
    return $stmt->fetch();
}

public function createUser($student_number, $name, $program, $sex, $gender_disclosure, $mobile, $landline, $email, $address, $password) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $this->pdo->prepare('
        INSERT INTO students 
        (student_number, name, program, sex, gender_disclosure, mobile, landline, email, address, password_hash) 
        VALUES 
        (:student_number, :name, :program, :sex, :gender_disclosure, :mobile, :landline, :email, :address, :password_hash)
    ');
    $stmt->execute([
        'student_number' => $student_number,
        'name' => $name,
        'program' => $program,
        'sex' => $sex,
        'gender_disclosure' => $gender_disclosure,
        'mobile' => $mobile,
        'landline' => $landline,
        'email' => $email,
        'address' => $address,
        'password_hash' => $hashedPassword
    ]);
  }
>>>>>>> Stashed changes
}
