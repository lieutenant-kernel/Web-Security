<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog Seite</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php
  session_start();
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
      header("Location: login.html");
      exit;
  }
  ?>
  <div class="container">
    <h1>Mein Blog</h1>
    <textarea id="blogText" style="width: 320px;"  placeholder="Schreibe deinen Blog hier..."></textarea>
    <button onclick="postBlog()">Posten</button>
    <button style="background-color: green;" onclick="previewBlog()">Vorschau</button>
    <div id="posts">
      <?php include 'save_post2.php'; ?>
    </div>
  </div>
  <script>
    function postBlog() {
      const blogText = document.getElementById("blogText").value;
      if (blogText.trim() !== "") {
        const formData = new FormData();
        formData.append('post', blogText);

        fetch('save_post2.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          console.log('Erfolg:', data);
          location.reload(); // Seite neu laden, um die neuen Posts anzuzeigen
        })
        .catch((error) => console.error('Fehler:', error));
      }
    }

    function previewBlog() {
      const blogText = document.getElementById("blogText").value;
      const previewWindow = window.open("", "_blank");
      previewWindow.document.write(`
        <!DOCTYPE html>
        <html lang="de">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Vorschau</title>
        </head>
        <body>
          <div class="container">
            <h1>Vorschau</h1>
            <div class="post">${blogText}</div>
          </div>
        </body>
        </html>
      `);
      previewWindow.document.close();
    }
  </script>
</body>
</html>
