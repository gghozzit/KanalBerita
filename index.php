<?php 
   session_start();
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

    <header class="py-5">
                <div class="container px-5 pb-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-xxl-5">
                            <div class="text-center text-xxl-start">
                                <div class="badge bg-gradient-primary-to-secondary text-white mb-4"></div>
                                <div class="fs-3 fw-light text-muted">Update Berita Terkini</div>
                                <h1 class="display-3 fw-bolder mb-5"><span class="text-gradient d-inline">Kanal Berita</span></h1>
                                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xxl-start mb-3">
                                    <a class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder" href="#">Berita</a>
                                    <a class="btn btn-primary-emphasis btn-lg px-5 py-3 fs-6 fw-bolder" href="admin/index.php">Bergabung</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-7">
                            <div class="d-flex justify-content-center mt-5 mt-xxl-0">
                                <div class="profile bg-gradient-primary-to-secondary">
                                    <img class="profile-img" src="images/koran.png" alt="Kanal Berita" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </header>

    <div class="container-fluid">
        <div class="row ms-5" style="margin-top: 4%">
        <div class="col-md-2 mt-4"></div>
            <div class="col-md-7">
            <h4 class="widget-title mb-4 text-center">Today Highlight </h4>
                <?php 
                     if (isset($_GET['pageno'])) {
                            $pageno = $_GET['pageno'];
                        } else {
                            $pageno = 1;
                        }
                        $no_of_records_per_page = 8;
                        $offset = ($pageno-1) * $no_of_records_per_page;
                     
                     
                        $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
                        $result = mysqli_query($con,$total_pages_sql);
                        $total_rows = mysqli_fetch_array($result)[0];
                        $total_pages = ceil($total_rows / $no_of_records_per_page);
                     
                     
                     $query=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=1 order by tblposts.id desc  LIMIT $offset, $no_of_records_per_page");
                     while ($row=mysqli_fetch_array($query)) {
                     ?>
                    <div class="col-md-6">
                        <div class="card mb-4 border-0">
                            <img class="card-img-top" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>" height="200px">
                            <div class="card-body">
                                <p class="m-0">
                                    <a class="badge bg-success text-decoration-none link-light" href="category.php?catid=<?php echo htmlentities($row['cid'])?>" style="color:#fff"><?php echo htmlentities($row['category']);?></a>
                                    <a class="badge bg-warning text-decoration-none link-light" style="color:#fff"><?php echo htmlentities($row['subcategory']);?></a>
                                </p>
                                <p class="m-0"><small> Posted on <?php echo htmlentities($row['postingdate']);?></small></p>
                                <a href="detail_berita.php?nid=<?php echo htmlentities($row['pid'])?>" class="card-title text-decoration-none text-dark">
                                    <h5 class="card-title"><?php echo htmlentities($row['posttitle']);?></h5>
                                </a>
                                <a href="detail_berita.php?nid=<?php echo htmlentities($row['pid'])?>" class="">Read More &rarr;</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-md-6"><a href="">
                        <ul class="pagination justify-content-center mb-4">
                        <li class="page-item"><a href="?pageno=1"  class="page-link border-0">First</a></li>
                        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-item">
                           <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" class="page-link border-0">Prev</a>
                        </li>
                        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
                           <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?> " class="page-link border-0">Next</a>
                        </li>
                        <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link border-0">Last</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    <?php include('includes/footer.php');?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>