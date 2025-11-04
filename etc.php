<?php
$conn = new mysqli("localhost","root","","simple_crud");

// Add
if(isset($_POST['add']))
  $conn->query("INSERT INTO books SET title='{$_POST['title']}', author='{$_POST['author']}'");

// Delete
if(isset($_GET['del']))
  $conn->query("DELETE FROM books WHERE id={$_GET['del']}");

// Get all
$res = $conn->query("SELECT * FROM books");
?>
<!DOCTYPE html>
<html>
<body>
<h2>📚 Simple Book Library</h2>

<!-- Add Book -->
<form method="post">
  <input name="title" placeholder="Title" required>
  <input name="author" placeholder="Author" required>
  <button name="add">Add</button>
</form>

<!-- Show Books -->
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Title</th><th>Author</th><th>Action</th></tr>
<?php while($b=$res->fetch_assoc()): ?>
<tr>
  <td><?= $b['id'] ?></td>
  <td><?= $b['title'] ?></td>
  <td><?= $b['author'] ?></td>
  <td><a href="?del=<?= $b['id'] ?>" onclick="return confirm('Delete this?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
