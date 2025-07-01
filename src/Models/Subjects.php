<?php
class Subjects {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addNewSubject($subjectData) {
        $stmt = $this->pdo->prepare("INSERT INTO subjects (grade_id, code, name, units) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $subjectData['grade_id'],
            $subjectData['code'],
            $subjectData['name'],
            $subjectData['units']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findSubjectByCode($code) {
        $stmt = $this->pdo->prepare('SELECT * FROM subjects WHERE code = :code');
        $stmt->execute(['code' => $code]);
        return $stmt->fetch();
    }

    public function findSubjectById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM subjects WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

}
?>