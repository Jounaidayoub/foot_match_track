<?php
session_start();
//notif for match creation notification
require '../includes/db.php';
global $bd;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['type'] == 'kickof_notif'){
        $match_id = $_POST['match_id'] ?? null;
        $event_type = $_POST['event_type'] ?? null;
        $message = $_POST['message'] ?? null;
        $team1_id = $_POST['team1_id'] ?? null;
        $team2_id = $_POST['team2_id'] ?? null;
        // Validate required fields
        // if (!$id_event || !$event_type || !$message) {
        //     echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        //     exit;
        // }

        try {
            followMatchForTeamFollower($match_id, $team1_id, $team2_id);
            $users = getMatchFollowers($match_id);
            //insert notif for match followers
            foreach ($users as $user) {
                $sql = "INSERT INTO notif (msg, event_id, event_type, date_notif, user_id) VALUES (:msg, :event_id, 'match', NOW(), :user_id)";
                $stmt = $bd->prepare($sql);
                $stmt->execute([
                    ':msg' => $message,
                    ':event_id' => $match_id,
                    ':user_id' => $user['id']
                ]);
            }

            echo json_encode(['success' => true, 'message' => 'Notifications sent successfully']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
        }
    }else if($_POST['type'] == 'read_all'){
        readAllNotif();
    }
    else {
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }

}

//follow matche for users who are following match teams
function followMatchForTeamFollower($id_match, $id_team1, $id_team2){
    global $bd;
        // Fetch users who follow either team and does not follow the match
        $sql = "SELECT follow.id_user from follow 
                WHERE ((follow.event_id = :team1_id OR follow.event_id = :team2_id) AND follow.event_type = 'team' )
                and follow.id_user not in (
                            select follow.id_user from follow 
                            where follow.event_type = 'match' and follow.event_id= :match_id
                            )";
        $stmt = $bd->prepare($sql);
        $stmt->execute([':team1_id' => $id_team1, ':team2_id' => $id_team2, ':match_id' => $id_match]);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //for each uer, follow the match
        foreach ($users as $user) {
            $sql = "INSERT INTO follow (id_user, event_id, event_type) VALUES (:id_user, :event_id, 'match')";
            $stmt = $bd->prepare($sql);
            $stmt->execute([
                ':id_user' => $user['id'],
                ':event_id' => $id_match
            ]);
        }
}

function getMatchFollowers($match_id){
    global $bd;
    $sql = "SELECT users.id FROM users JOIN follow ON users.id = follow.id_user WHERE follow.event_id = :match_id AND follow.event_type = 'match'";
    $stmt = $bd->prepare($sql);
    $stmt->execute([':match_id' => $match_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function readAllNotif(){
    global $bd;
    $id_user = $_SESSION['id'];
    //update all notif for the user to read
    $sql = "UPDATE notif SET is_read = 1 WHERE id_user = :id_user";
    $stmt = $bd->prepare($sql);
    $stmt->execute([':id_user' => $id_user]);
    echo json_encode(['success' => true, 'message' => 'All notifications marked as read']);
}

if($_SERVER['REQUEST_METHOD'] === 'GET'){

    function getNotif(){
        global $bd;
        $id_user = $_SESSION['id'];

        $sql = "select notif.id_user, notif.msg, notif.date_notif, notif.is_read,notif.event_id,
                notif.event_type from notif  
                where notif.id_user = :id_user order by notif.date_notif desc";
        $stmt = $bd->prepare($sql);
        $stmt->execute([':id_user' => $id_user]);
        $notifs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response = [
            'success' => true,
            'notifs' => $notifs
        ];
        echo json_encode($response);
    }
    getNotif();

}
?>