<?php

$db_host = "127.0.0.1";
$db_port = "3306";
$db_database = "telu";
$db_username = "root";
$db_password = "";

$connection = mysqli_connect($db_host, $db_username, $db_password, $db_database, $db_port);

if (!$connection) {
  die("Cant connect to database");
}

$nim      = "";
$nama     = "";
$prodi    = "";
$fakultas = "";
$success  = "";
$error    = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}
if ($op == 'delete') {
  $id         = $_GET['id'];
  $sql1       = "delete from mahasiswa where id = '$id'";
  $q1         = mysqli_query($connection, $sql1);
  if ($q1) {
    $success = "successfully deleted data";
  } else {
    $error  = "failed to delete data";
  }
}
if ($op == 'edit') {
  $id         = $_GET['id'];
  $sql1       = "select * from mahasiswa where id = '$id'";
  $q1         = mysqli_query($connection, $sql1);
  $r1         = mysqli_fetch_array($q1);
  $nim        = $r1['nim'];
  $nama       = $r1['nama'];
  $fakultas   = $r1['fakultas'];
  $prodi      = $r1['prodi'];

  if ($nim == '') {
    $error = "data not found";
  }
}
if (isset($_POST['submit'])) { //untuk create
  $nim        = $_POST['nim'];
  $nama       = $_POST['nama'];
  $fakultas   = $_POST['fakultas'];
  $prodi      = $_POST['prodi'];

  if ($nim && $nama && $fakultas && $prodi) {
    if ($op == 'edit') { //untuk update
      $sql1       = "update mahasiswa set nim = '$nim',nama='$nama',fakultas = '$fakultas',prodi='$prodi' where id = '$id'";
      $q1         = mysqli_query($connection, $sql1);
      if ($q1) {
        $success = "data updated successfully";
      } else {
        $error  = "data failed to update";
      }
    } else { //untuk insert
      $sql1   = "insert into mahasiswa(nim,nama,fakultas,prodi) values ('$nim','$nama','$fakultas','$prodi')";
      $q1     = mysqli_query($connection, $sql1);
      if ($q1) {
        $success     = "succesfully input new data";
      } else {
        $error      = "failed to input new data";
      }
    }
  } else {
    $error = "please input all data";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <style>
    .mx-auto {
      width: 1000px
    }

    .card {
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div class="mx-auto">
    <!-- input data -->
    <div class="card">
      <div class="card-header">
        Create / Edit Data
      </div>
      <div class="card-body">
        <?php
        if ($error) {
        ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
        <?php
        }
        ?>
        <?php
        if ($success) {
        ?>
          <div class="alert alert-success" role="alert">
            <?php echo $success ?>
          </div>
        <?php
        }
        ?>
        <form action="" method="POST">
          <div class="mb-3 row">
            <label for="nim" class="col-sm-2 col-form-label">NIM</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="fakultas" name="fakultas" value="<?php echo $fakultas ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="prodi" class="col-sm-2 col-form-label">Prodi</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="prodi" name="prodi" value="<?php echo $prodi ?>">
            </div>
          </div>
          <div class="col-12">
            <input type="submit" name="submit" value="Save" class="btn btn-primary" />
          </div>
        </form>
      </div>
    </div>

    <!-- untuk mengeluarkan data -->
    <div class="card">
      <div class="card-header text-white bg-secondary">
        Data Mahasiswa
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">NIM</th>
              <th scope="col">Nama</th>
              <th scope="col">Fakultas</th>
              <th scope="col">Prodi</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql2   = "select * from mahasiswa order by id desc";
            $q2     = mysqli_query($connection, $sql2);
            $sort   = 1;
            while ($r2 = mysqli_fetch_array($q2)) {
              $id         = $r2['id'];
              $nim        = $r2['nim'];
              $nama       = $r2['nama'];
              $fakultas   = $r2['fakultas'];
              $prodi      = $r2['prodi'];

            ?>
              <tr>
                <th scope="row"><?php echo $sort++ ?></th>
                <td scope="row"><?php echo $nim ?></td>
                <td scope="row"><?php echo $nama ?></td>
                <td scope="row"><?php echo $fakultas ?></td>
                <td scope="row"><?php echo $prodi ?></td>
                <td scope="row">
                  <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                  <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Are you sure you want to delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>

        </table>
      </div>
    </div>
  </div>
</body>

</html>