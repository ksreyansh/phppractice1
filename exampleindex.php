<?php
//Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "inotes";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            Database connecion unsuccessful!
            </div>';
}

//Insert a record into notes table
//$sql = 'INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES ('', '', '', current_timestamp())';

//update notes in table
if ($_SERVER['REQUEST_METHOD'] == "POST") {
if (isset($_POST['snoEdit'])) {
        //Update post
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];
        $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn, $sql); 
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
        $('#myTable').DataTable();
        } );  
    </script>
    

    <title>Hello, world!</title>
  </head>
  <body>
    
      <!-- Button trigger modal -->
<!--button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <input type="hidden" name="snoEdit" id="snoEdit">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="index.php" method="post">
<div class="container my-4">
    
   <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Note Title</label>
  <input type="text" class="form-control" placeholder="Add a title...." id="titleEdit" name="titleEdit">
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Note Description</label>
  <textarea class="form-control" rows="3" placeholder="Add a description...." id="descriptionEdit" name="descriptionEdit"></textarea>
</div>
    <button type="submit" class="btn btn-primary">Update Note</button>
</div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
      
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">iNotes</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>  
<form action="index.php" method="post">
<div class="container my-4">
    <h3>Add a new note</h3>
   <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Note Title</label>
  <input type="text" class="form-control" placeholder="Add a title...." id="title" name="title">
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Note Description</label>
  <textarea class="form-control" rows="3" placeholder="Add a description...." id="description" name="description"></textarea>
</div>
    <button type="submit" class="btn btn-primary">Add Note</button>
</div>
</form>
<div class="container">
      <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'] ?? "";
        $description = $_POST['description'] ?? "";
        $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description');";
        $result = mysqli_query($conn, $sql);
           }
    ?>
</div>
<div class="container">

    

<table class="table my-4" id="myTable">
  <thead>
    <tr>
      <th scope="col">S No.</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
     <?php
    $query = "SELECT * FROM `notes`";
    $result = mysqli_query($conn, $query);
    $sno = 0;  
    while ($row = mysqli_fetch_assoc($result)) {
        $sno = $sno+1;
        echo "<tr>
        <td>".$sno."</td>
        <td>".$row['title']."</td>
        <td>".$row['description']."</td>
        <td><button type='button' class='edit btn btn-primary' id=".$row['sno'].">Edit</button> | <a href='/del'> Delete </a></td>
        </tr>";
        } ?>
      
    
    
</tbody>
</table>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((Element)=>{
            Element.addEventListener("click", (e)=> {
                console.log("edit", e);
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[1].innerText;
                description = tr.getElementsByTagName("td")[2].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                var editModal = new bootstrap.Modal(document.getElementById('editModal'), {
                    keyboard: false
                })
                editModal.toggle()
            })
        })
    
      
    </script>
    
</div>
      
    
      

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    -->
  </body>
</html>
