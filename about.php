<?php
include('includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Kanal Berita</title>
</head>

<body>
    <?php include('includes/header.php');?>
    <div class="container">
        <br>
    <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">About</li>
        </ol>
        <?php 
            $pagetype='aboutus';
            $query=mysqli_query($con,"select PageTitle,Description from tblpages where PageName='$pagetype'");
            while($row=mysqli_fetch_array($query))
            {
        ?>
        <h1 class="mt-5 mb-3 text-center"><?php echo htmlentities($row['PageTitle'])?></h1>
        <div class="row">
            <div class="col-lg-12">
                <p><?php echo $row['Description'];?></p>
            </div>
        </div>
        <?php } ?>
    </div>
<br>
    <?php include('includes/footer.php');?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>