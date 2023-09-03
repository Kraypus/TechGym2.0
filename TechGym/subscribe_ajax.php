<?php
session_start();
$mysqli = require __DIR__ . "/database.php";

if (isset($_POST["subscribed_user_id"]) && isset($_SESSION["user_id"])) {
    $subscribed_user_id = $_POST["subscribed_user_id"];
    $subscriber_user_id = $_SESSION["user_id"];

    // Get the previously subscribed user_id for the current subscriber
    $previously_subscribed_query = "SELECT routine FROM user WHERE id = {$subscriber_user_id}";
    $previously_subscribed_result = $mysqli->query($previously_subscribed_query);
    $previously_subscribed_row = $previously_subscribed_result->fetch_assoc();
    $previously_subscribed_id = $previously_subscribed_row['routine'];

    // Check if the subscriber is already subscribed
    $check_subscription_query = "SELECT routine FROM user WHERE id = {$subscriber_user_id}";
    $check_subscription_result = $mysqli->query($check_subscription_query);

    if ($check_subscription_result) {
        $subscriber_row = $check_subscription_result->fetch_assoc();
        $current_routine = $subscriber_row['routine'];

        if ($current_routine == $subscribed_user_id) {
            // Unsubscribe: Set routine content to 0
            $update_routine_query = "UPDATE user SET routine = 0 WHERE id = {$subscriber_user_id}";
            if ($mysqli->query($update_routine_query)) {
                // Update the subscribers count for the previously subscribed user
                $update_prev_subscribers_query = "UPDATE routine SET subscribers = (SELECT COUNT(*) FROM user WHERE routine = {$previously_subscribed_id}) WHERE user_id = {$previously_subscribed_id}";
                if (!$mysqli->query($update_prev_subscribers_query)) {
                    echo "Failed to update subscribers count for previously subscribed user. Error: {$mysqli->error}";
                }

                // Update the subscribers count for the current subscribed user
                $update_curr_subscribers_query = "UPDATE routine SET subscribers = (SELECT COUNT(*) FROM user WHERE routine = {$subscribed_user_id}) WHERE user_id = {$subscribed_user_id}";
                if (!$mysqli->query($update_curr_subscribers_query)) {
                    echo "Failed to update subscribers count for current subscribed user. Error: {$mysqli->error}";
                }

                // Unsubscribed successfully
                $_SESSION["subscribed_$subscribed_user_id"] = false;
                echo "Subscribe";
            } else {
                // Unsubscription failed
                echo "Failed to unsubscribe. Error: {$mysqli->error}";
            }
        } else {
            // Subscribe: Set routine content to subscribed_user_id
            $update_routine_query = "UPDATE user SET routine = {$subscribed_user_id} WHERE id = {$subscriber_user_id}";
            if ($mysqli->query($update_routine_query)) {
                // Update the subscribers count for the previously subscribed user
                $update_prev_subscribers_query = "UPDATE routine SET subscribers = (SELECT COUNT(*) FROM user WHERE routine = {$previously_subscribed_id}) WHERE user_id = {$previously_subscribed_id}";
                if (!$mysqli->query($update_prev_subscribers_query)) {
                    echo "Failed to update subscribers count for previously subscribed user. Error: {$mysqli->error}";
                }

                // Update the subscribers count for the current subscribed user
                $update_curr_subscribers_query = "UPDATE routine SET subscribers = (SELECT COUNT(*) FROM user WHERE routine = {$subscribed_user_id}) WHERE user_id = {$subscribed_user_id}";
                if (!$mysqli->query($update_curr_subscribers_query)) {
                    echo "Failed to update subscribers count for current subscribed user. Error: {$mysqli->error}";
                }

                // Subscribed successfully
                $_SESSION["subscribed_$subscribed_user_id"] = true;
                echo "Unsubscribe";
            } else {
                // Subscription failed
                echo "Failed to subscribe. Error: {$mysqli->error}";
            }
        }
    } else {
        // Error fetching subscriber's routine
        echo "Failed to check subscription. Error: {$mysqli->error}";
    }
}
?>
