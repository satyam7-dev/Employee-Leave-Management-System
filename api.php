<?php
require_once 'config.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch($action) {
    case 'get_leave_types':
        $stmt = $pdo->query("SELECT * FROM leave_types");
        echo json_encode($stmt->fetchAll());
        break;
        
    case 'submit_leave':
        if ($_SESSION['role'] !== 'employee') {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            break;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO leave_requests (user_id, leave_type_id, start_date, end_date, total_days, reason) VALUES (?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            $_SESSION['user_id'],
            $data['leave_type_id'],
            $data['start_date'],
            $data['end_date'],
            $data['total_days'],
            $data['reason']
        ]);
        echo json_encode(['success' => $success]);
        break;
        
    case 'get_pending_requests':
        if ($_SESSION['role'] !== 'manager') {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            break;
        }
        
        $stmt = $pdo->query("SELECT lr.*, u.full_name, lt.type_name FROM leave_requests lr 
                            JOIN users u ON lr.user_id = u.id 
                            JOIN leave_types lt ON lr.leave_type_id = lt.id 
                            WHERE lr.status = 'pending'");
        echo json_encode($stmt->fetchAll());
        break;
        
    case 'update_request':
        if ($_SESSION['role'] !== 'manager') {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            break;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("UPDATE leave_requests SET status = ?, manager_comments = ?, manager_id = ? WHERE id = ?");
        $success = $stmt->execute([
            $data['status'],
            $data['comments'],
            $_SESSION['user_id'],
            $data['request_id']
        ]);
        
        // Update leave balance if approved
        if ($data['status'] === 'approved') {
            $reqStmt = $pdo->prepare("SELECT * FROM leave_requests WHERE id = ?");
            $reqStmt->execute([$data['request_id']]);
            $request = $reqStmt->fetch();
            
            $balanceStmt = $pdo->prepare("UPDATE leave_balances SET used_days = used_days + ? WHERE user_id = ? AND leave_type_id = ?");
            $balanceStmt->execute([$request['total_days'], $request['user_id'], $request['leave_type_id']]);
        }
        
        echo json_encode(['success' => $success]);
        break;
        
    case 'get_my_requests':
        $stmt = $pdo->prepare("SELECT lr.*, lt.type_name FROM leave_requests lr 
                              JOIN leave_types lt ON lr.leave_type_id = lt.id 
                              WHERE lr.user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$_SESSION['user_id']]);
        echo json_encode($stmt->fetchAll());
        break;
        
    case 'get_leave_balance':
        $stmt = $pdo->prepare("SELECT lb.*, lt.type_name FROM leave_balances lb 
                              JOIN leave_types lt ON lb.leave_type_id = lt.id 
                              WHERE lb.user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        echo json_encode($stmt->fetchAll());
        break;
        
    case 'get_calendar_data':
        $stmt = $pdo->query("SELECT lr.*, u.full_name FROM leave_requests lr 
                            JOIN users u ON lr.user_id = u.id 
                            WHERE lr.status = 'approved'");
        echo json_encode($stmt->fetchAll());
        break;
}
?>
