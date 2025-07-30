<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lesson</title>
    <script src="../tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#lesson_proper',
            plugins: 'lists link image table code textcolor',
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code | fontsizeselect | lineheightselect',
            menubar: false,
            setup: function (editor) {
            editor.ui.registry.addMenuButton('lineheightselect', {
                text: 'Line Height',
                fetch: function (callback) {
                const items = [
                    { text: '1', value: '1' },
                    { text: '1.5', value: '1.5' },
                    { text: '2', value: '2' },
                    { text: '2.5', value: '2.5' },
                    { text: '3', value: '3' }
                ];
                callback(items.map(item => ({
                    type: 'menuitem',
                    text: item.text,
                    onAction: function () {
                    editor.execCommand('mceLineHeight', false, item.value);
                    }
                })));
                }
            });
            }
        });
    </script>
</head>
<body>
    <?php
    // Database connection
    include '../connection.php';

    // Fetch the lesson content
    $lessonId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $stmt = $conn->prepare("SELECT lesson_proper FROM lessons WHERE id = ?");
    $stmt->bind_param("i", $lessonId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Lesson not found.");
    }

    $lesson = $result->fetch_assoc();
    $stmt->close();
    ?>

    <h1>Edit Lesson</h1>
    <form action="save_lesson.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $lessonId; ?>">
        <textarea id="lesson_proper" name="lesson_proper" rows="20" cols="80">
            <?php echo htmlspecialchars($lesson['lesson_proper']); ?>
        </textarea>
        <br>
        <button type="submit">Save Lesson</button>
    </form>
</body>
</html>