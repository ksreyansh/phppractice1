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

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.css">
    
      

    <title>I-notes!</title>
  </head>
  <body>
      
<div class="modal" tabindex="-1" id="editModal" name="editModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
            <form class="needs-validation" action="welcome.php" method="post">
                <input type="hidden" name="snoEdit" id="snoEdit">
    <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="titleEdit" name="titleEdit" placeholder="Enter note title..." required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3" placeholder="Enter note description..." required></textarea>
    </div>
    <button class="btn btn-md btn-primary" type="submit">Update Note</button>
    </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
          <a class="nav-link" href="#">About Us</a>
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
<div class="container my-4">
    <form class="needs-validation" action="welcome.php" method="post">
    <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter note title..." required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter note description..." required></textarea>
    </div>
    <button class="btn btn-md btn-primary" type="submit">Add Note</button>
    </form>
    <div class="container">
            <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    if (isset($_POST['snoEdit'])){
                        $sno = $_POST['snoEdit'];
                        $title = $_POST['titleEdit'] ?? "";
                        $description = $_POST['descriptionEdit'] ?? "";
                        $update = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno;";
                        $uresult = mysqli_query($conn,$update);
                    }
                    else {
                    $title = $_POST['title'] ?? "";
                    $description = $_POST['description'] ?? "";
                    $insert = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description');";
                    $iresult = mysqli_query($conn, $insert);
                    /**if (!$iresult) {
                        echo '<div class="alert alert-warning alert-dismissible" role="alert" id="liveAlert">
                                Record updation unsuccessful!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                    }
                    else {
                        echo '<div class="alert alert-primary alert-dismissible" role="alert" id="liveAlert">
                                Record updated successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                    }**/
                
                }
                }
            ?>
    </div>
</div>
<?php

      
      
?>

<div class="container">
<table class="table" id="myTable">
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
        $select = "SELECT * FROM `notes`;";
        $result = mysqli_query($conn, $select);
        $s = 1;
        /**if (!$result) {
            echo 'cannot display table';
            
        }
        else {
            echo 'successful';
        }**/
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><th scope='row'>".$s."</th>
                      <td>".$row['title']."</td>
                      <td>".$row['description']."</td>
                      <td>"."<div class='d-grid gap-2 d-md-flex'>
                            <button class='edit btn btn-primary me-md-2' type='button' id=".$row['sno'].">Edit</button>
                            <a class='delete'><button class='btn btn-primary' type='button'>Delete</button>
                            </a></div>"."</td>
                </tr>";
            $s++;
        }    
        
    ?>
    </tbody>
</table>
    

</div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
      

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.js"></script>
    <script>
            $(document).ready( function () {
            $('#myTable').DataTable();
            } );
      </script>
      
    <script type="text/javascript">
    
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element)=>{
            element.addEventListener("click", (e)=> {
                console.log("edit", );
                tr = e.target.parentNode.parentNode.parentNode;
                title = tr.getElementsByTagName('td')[0].innerText;
                description = tr.getElementsByTagName('td')[1].innerText;
                
                snoEdit.value = e.target.id;
                titleEdit.value = title;
                descriptionEdit.value = description;
                console.log(e.target.id, title, description);
                var editModal = new bootstrap.Modal(document.getElementById('editModal'), {
                keyboard: false
                })
                editModal.toggle();
            })
        })
      
    </script>
    
  </body>
</html>
