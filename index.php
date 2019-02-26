<?php

// DATABASE CLASS
require('class/database.class.php');
$database = new Database();

// USERS SAMPLE CLASS
require('class/users.class.php');
$users = new Users($database);
?>

<html>
<head>
<title>Sample Page</title>
</head>
<body>

<b>TEST SAMPLE FOR DB</b>
<p>
<?php echo $users->findSingleUser('1'); ?>
<p>
<?php foreach ($users->listAllUsers() as $key => $value): ?>
   <?php echo $value['firstname'].''.$value['lastname'];?>
   <br>
<?php endforeach; ?>

<p>
<b>SELECT ROW DB Code Example:</b>
<pre>
  $this->database->query('SELECT * FROM users WHERE id = :userid');
  $this->database->bind(':userid', $userid);
  $row = $this->database->single();

  if ($row) {
      return $row['firstname'].' '.$row['lastname'];
  }
</pre>
<p>
<b>SELECT ALL ROWS (OUTPUT:ARRAY) DB Code Example:</b>
<pre>
  $returnValue = array();

  $this->database->query('SELECT * FROM users ORDER BY id ASC');

  $rows = $this->database->resultset();

  foreach ($rows as $row):

  $returnValue[] = array(
  'id'   => $row['id'],
  'firstname' => $row['firstname'],
  'lastname' => $row['lastname'],
  'timestamp' => $row['timestamp']
  );

  endforeach;

  return $returnValue;
</pre>
<p>
<b>Insert DB Code Example:</b>
<pre>
  $this->database->beginTransaction();
  $this->database->query('INSERT INTO users (
        firstname,
        lastname
        ) VALUES (
        :firstname,
        :lastname
        )');
  $this->database->bind(':firstname', $firstname);
  $this->database->bind(':lastname', $lastname);
  $this->database->execute();
  $this->database->endTransaction();
</pre>
<p>
<b>Update DB Code Example:</b>
<pre>
  $this->database->beginTransaction();
  $this->database->query('UPDATE users SET firstname =:firstname, user_ip =:user_ip where id =:id');
  $this->database->bind(':id', $userid);
  $this->database->bind(':firstname', $firstname);
  $this->database->bind(':lastname', $lastname);
  $this->database->execute();
  $this->database->endTransaction();
</pre>
<b>Delete DB Code Example:</b>
<pre>
  $this->database->beginTransaction();
  $this->database->query('DELETE FROM users WHERE id = :id');
  $this->database->bind(':id', $userid);
  $this->database->execute();
  $this->database->endTransaction();
</pre>
</body>
</html>
