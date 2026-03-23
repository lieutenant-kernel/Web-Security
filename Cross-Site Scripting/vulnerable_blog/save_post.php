<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post = $_POST['post'];
    $posts = json_decode(file_get_contents('posts.json'), true) ?? [];
    $posts[] = $post;
    file_put_contents('posts.json', json_encode($posts));
    echo 'Post erfolgreich gespeichert';
} else {
    $posts = json_decode(file_get_contents('posts.json'), true) ?? [];
    foreach ($posts as $post) {
        echo "<div class='post'>$post</div>";
    }
}
?>
