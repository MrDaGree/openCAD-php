<?php

require_once('../oc-config.php');

if (isset($_GET['responder']))
{
    logoutResponder();
}

//Need to make sure they're out of the active_users table
function logoutResponder()
{
    $identifier = $_GET['responder'];

    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if (!$link) {
		die('Could not connect: ' .mysql_error());
	}

    $sql = "DELETE FROM active_users WHERE identifier = ?";

    try {
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "s", $identifier);
        $result = mysqli_stmt_execute($stmt);

        if ($result == FALSE) {
            die(mysqli_error($link));
        }
    }
    catch (Exception $e)
    {
        die("Failed to run query: " . $e->getMessage()); //TODO: A function to send me an email when this occurs should be made
    }

    mysqli_close($link);
}

session_start();
session_unset();
session_destroy();

header("Location: ../index.php?loggedOut=true");
exit();
?>
