<?php
/**
 * CCMS Backend Notice:
 * The PHP and MySQL backend has been completely migrated to a pure Python 
 * zero-dependency architecture (app.py + static_data.py + db.py).
 * 
 * To run the project:
 *    python app.py
 * Access at: http://127.0.0.1:5000
 */
header('Content-Type: application/json');
echo json_encode([
    "status" => "migrated",
    "message" => "Backend migrated to pure Python static architecture. Run 'python app.py' to launch."
]);
?>